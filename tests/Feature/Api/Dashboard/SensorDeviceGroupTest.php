<?php

use App\Models\Sensor;
use App\Models\SensorDevice;
use App\Models\SensorDeviceGroup;
use App\Models\SensorParameter;
use App\Models\Telemetry;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

it('requires authentication', function () {
    $this->getJson(route('dashboard.sensor-device-groups.index'))
        ->assertUnauthorized();
});

it('returns an empty list when no sensor device groups exist', function () {
    $this->actingAs(User::factory()->create())
        ->getJson(route('dashboard.sensor-device-groups.index'))
        ->assertSuccessful()
        ->assertJsonCount(0, 'data');
});

it('returns a list of sensor device groups with devices and telemetry', function () {
    $group = SensorDeviceGroup::factory()->create();
    $sensor = Sensor::factory()->create();
    $parameter = SensorParameter::factory()->create(['sensor_id' => $sensor->id]);

    $device = SensorDevice::factory()->create([
        'sensor_id' => $sensor->id,
        'sensor_device_group_id' => $group->id,
    ]);

    Telemetry::factory()->create([
        'sensor_device_id' => $device->id,
        'sensor_parameter_id' => $parameter->id,
        'value' => 25.5,
    ]);

    $this->actingAs(User::factory()->create())
        ->getJson(route('dashboard.sensor-device-groups.index'))
        ->assertSuccessful()
        ->assertJsonCount(1, 'data')
        ->assertJsonCount(1, 'data.0.sensorDevices')
        ->assertJsonCount(1, 'data.0.sensorDevices.0.latestTelemetry');
});

it('returns the correct json structure', function () {
    $group = SensorDeviceGroup::factory()->create();
    $sensor = Sensor::factory()->create();
    $parameter = SensorParameter::factory()->create(['sensor_id' => $sensor->id]);

    $device = SensorDevice::factory()->create([
        'sensor_id' => $sensor->id,
        'sensor_device_group_id' => $group->id,
    ]);

    Telemetry::factory()->create([
        'sensor_device_id' => $device->id,
        'sensor_parameter_id' => $parameter->id,
    ]);

    $this->actingAs(User::factory()->create())
        ->getJson(route('dashboard.sensor-device-groups.index'))
        ->assertSuccessful()
        ->assertJsonStructure([
            'data' => [
                '*' => [
                    'name',
                    'sensorDevices' => [
                        '*' => [
                            'name',
                            'latestTelemetry' => [
                                '*' => [
                                    'value',
                                    'updatedAt',
                                    'parameterName',
                                    'parameterUnit',
                                    'parameterIcon',
                                ],
                            ],
                        ],
                    ],
                ],
            ],
        ]);
});

it('returns only the latest telemetry per parameter', function () {
    $group = SensorDeviceGroup::factory()->create();
    $sensor = Sensor::factory()->create();
    $parameter = SensorParameter::factory()->create(['sensor_id' => $sensor->id]);

    $device = SensorDevice::factory()->create([
        'sensor_id' => $sensor->id,
        'sensor_device_group_id' => $group->id,
    ]);

    Telemetry::factory()->create([
        'sensor_device_id' => $device->id,
        'sensor_parameter_id' => $parameter->id,
        'value' => 10.0,
        'created_at' => now()->subHour(),
    ]);

    $latest = Telemetry::factory()->create([
        'sensor_device_id' => $device->id,
        'sensor_parameter_id' => $parameter->id,
        'value' => 25.5,
        'created_at' => now(),
    ]);

    $response = $this->actingAs(User::factory()->create())
        ->getJson(route('dashboard.sensor-device-groups.index'))
        ->assertSuccessful();

    $telemetry = $response->json('data.0.sensorDevices.0.latestTelemetry');

    expect($telemetry)->toHaveCount(1)
        ->and($telemetry[0]['value'])->toBe($latest->value);
});
