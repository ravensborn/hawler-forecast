<?php

namespace App\Console\Commands;

use App\Models\SensorParameter;
use App\Models\Telemetry;
use App\Services\TeknykarIotService;
use Illuminate\Console\Command;

class FetchTelemetryData extends Command
{
    protected $signature = 'telemetry:fetch';

    protected $description = 'Fetch latest sensor readings from the Teknykar IoT platform';

    public function handle(TeknykarIotService $service): void
    {
        $parameters = SensorParameter::query()
            ->with('sensorDevice')
            ->get()
            ->keyBy('platform_parameter_id');

        if ($parameters->isEmpty()) {
            $this->warn('No sensor parameters found.');

            return;
        }

        $this->info("Fetching data for {$parameters->count()} endpoints...");

        $stored = 0;

        $parameters
            ->keys()
            ->chunk(5)
            ->each(function ($chunk) use ($service, $parameters, &$stored) {
                $readings = $service->fetchEndpointData($chunk->values()->all());

                $this->line('Chunk '.implode(',', $chunk->all()).' → '.count($readings).' readings');

                foreach ($readings as $reading) {
                    $parameter = $parameters->get($reading['EndpointID']);

                    if (! $parameter) {
                        $this->warn("  No parameter for EndpointID {$reading['EndpointID']}");

                        continue;
                    }

                    $device = $parameter->sensorDevice;

                    if (! $device) {
                        $this->warn("  No device for parameter {$parameter->name}");

                        continue;
                    }

                    Telemetry::create([
                        'sensor_device_id'    => $device->id,
                        'sensor_parameter_id' => $parameter->id,
                        'value'               => $reading['Value'],
                    ]);

                    $this->line("  ✓ {$parameter->name} = {$reading['Value']} (device: {$device->id})");
                    $stored++;
                }
            });

        $this->info("Done. Stored {$stored} telemetry readings.");
    }
}
