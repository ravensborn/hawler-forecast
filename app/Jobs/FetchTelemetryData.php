<?php

namespace App\Jobs;

use App\Models\SensorParameter;
use App\Models\Telemetry;
use App\Services\TeknykarIotService;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;

class FetchTelemetryData implements ShouldQueue
{
    use Queueable;

    /**
     * Execute the job.
     */
    public function handle(TeknykarIotService $service): void
    {
        $parameters = SensorParameter::query()
            ->with('sensor.sensorDevices')
            ->get()
            ->keyBy('platform_parameter_id');

        $parameters
            ->keys()
            ->chunk(5)
            ->each(function ($chunk) use ($service, $parameters) {
                $readings = $service->fetchEndpointData($chunk->values()->all());

                foreach ($readings as $reading) {
                    $parameter = $parameters->get($reading['EndpointID']);

                    if (! $parameter) {
                        continue;
                    }

                    $device = $parameter->sensor->sensorDevices->first();

                    if (! $device) {
                        continue;
                    }

                    Telemetry::create([
                        'sensor_device_id' => $device->id,
                        'sensor_parameter_id' => $parameter->id,
                        'value' => $reading['Value'],
                    ]);
                }
            });
    }
}
