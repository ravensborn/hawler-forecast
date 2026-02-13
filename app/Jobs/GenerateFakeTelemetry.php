<?php

namespace App\Jobs;

use App\Models\SensorDevice;
use App\Models\Telemetry;
use Illuminate\Foundation\Queue\Queueable;

class GenerateFakeTelemetry
{
    use Queueable;

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $devices = SensorDevice::query()
            ->with('sensor.sensorParameters')
            ->get();

        foreach ($devices as $device) {
            foreach ($device->sensor->sensorParameters as $parameter) {
                Telemetry::create([
                    'sensor_device_id' => $device->id,
                    'sensor_parameter_id' => $parameter->id,
                    'value' => fake()->randomFloat(2, 0, 100),
                ]);
            }
        }
    }
}
