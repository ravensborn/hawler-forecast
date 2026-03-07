<?php

use App\Enums\AlertRuleOperator;
use App\Enums\AlertType;
use App\Models\Alert;
use App\Models\AlertRule;
use App\Models\SensorDevice;
use App\Models\SensorParameter;
use App\Models\Telemetry;
use App\Services\TeknykarIotService;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

it('creates an alert when a rule threshold is exceeded', function () {
    $device = SensorDevice::factory()->create();
    $parameter = SensorParameter::factory()->create(['sensor_device_id' => $device->id, 'name' => 'Temperature']);

    $rule = AlertRule::factory()->create([
        'operator' => AlertRuleOperator::GreaterThan,
        'threshold' => 40.0,
        'cooldown_hours' => 6,
        'alert_type' => AlertType::Danger,
    ]);
    $rule->sensorParameters()->attach($parameter->id);

    $service = Mockery::mock(TeknykarIotService::class);
    $service->shouldReceive('fetchEndpointData')->andReturn([
        ['EndpointID' => $parameter->platform_parameter_id, 'Value' => 45.0],
    ]);

    $this->app->instance(TeknykarIotService::class, $service);

    $this->artisan('telemetry:fetch')->assertSuccessful();

    expect(Alert::where('alert_rule_id', $rule->id)->count())->toBe(1);
});

it('does not create an alert when value is below threshold', function () {
    $device = SensorDevice::factory()->create();
    $parameter = SensorParameter::factory()->create(['sensor_device_id' => $device->id, 'name' => 'Temperature']);

    $rule = AlertRule::factory()->create([
        'operator' => AlertRuleOperator::GreaterThan,
        'threshold' => 40.0,
    ]);
    $rule->sensorParameters()->attach($parameter->id);

    $service = Mockery::mock(TeknykarIotService::class);
    $service->shouldReceive('fetchEndpointData')->andReturn([
        ['EndpointID' => $parameter->platform_parameter_id, 'Value' => 35.0],
    ]);

    $this->app->instance(TeknykarIotService::class, $service);

    $this->artisan('telemetry:fetch')->assertSuccessful();

    expect(Alert::where('alert_rule_id', $rule->id)->count())->toBe(0);
});

it('respects cooldown across all parameters sharing the same rule', function () {
    $device = SensorDevice::factory()->create();
    $paramA = SensorParameter::factory()->create([
        'sensor_device_id' => $device->id,
        'name' => 'Temperature',
        'platform_parameter_id' => 1001,
    ]);
    $paramB = SensorParameter::factory()->create([
        'sensor_device_id' => $device->id,
        'name' => 'Temperature',
        'platform_parameter_id' => 1002,
    ]);

    $rule = AlertRule::factory()->create([
        'operator' => AlertRuleOperator::GreaterThan,
        'threshold' => 40.0,
        'cooldown_hours' => 6,
    ]);
    $rule->sensorParameters()->attach([$paramA->id, $paramB->id]);

    // First fetch: paramA triggers the rule
    $service = Mockery::mock(TeknykarIotService::class);
    $service->shouldReceive('fetchEndpointData')->andReturn([
        ['EndpointID' => 1001, 'Value' => 50.0],
    ]);
    $this->app->instance(TeknykarIotService::class, $service);
    $this->artisan('telemetry:fetch')->assertSuccessful();

    expect(Alert::where('alert_rule_id', $rule->id)->count())->toBe(1);

    // Second fetch: paramB also exceeds but rule is on cooldown
    $service = Mockery::mock(TeknykarIotService::class);
    $service->shouldReceive('fetchEndpointData')->andReturn([
        ['EndpointID' => 1002, 'Value' => 50.0],
    ]);
    $this->app->instance(TeknykarIotService::class, $service);
    $this->artisan('telemetry:fetch')->assertSuccessful();

    expect(Alert::where('alert_rule_id', $rule->id)->count())->toBe(1);
});

it('triggers again after cooldown expires', function () {
    $device = SensorDevice::factory()->create();
    $parameter = SensorParameter::factory()->create(['sensor_device_id' => $device->id]);

    $rule = AlertRule::factory()->create([
        'operator' => AlertRuleOperator::GreaterThan,
        'threshold' => 40.0,
        'cooldown_hours' => 6,
    ]);
    $rule->sensorParameters()->attach($parameter->id);

    // Create an old alert outside the cooldown window
    Alert::factory()->create([
        'alert_rule_id' => $rule->id,
        'created_at' => now()->subHours(7),
    ]);

    $service = Mockery::mock(TeknykarIotService::class);
    $service->shouldReceive('fetchEndpointData')->andReturn([
        ['EndpointID' => $parameter->platform_parameter_id, 'Value' => 50.0],
    ]);
    $this->app->instance(TeknykarIotService::class, $service);

    $this->artisan('telemetry:fetch')->assertSuccessful();

    expect(Alert::where('alert_rule_id', $rule->id)->count())->toBe(2);
});

it('evaluates all operator types correctly', function () {
    expect(AlertRuleOperator::GreaterThan->evaluate(10, 5))->toBeTrue()
        ->and(AlertRuleOperator::GreaterThan->evaluate(5, 10))->toBeFalse()
        ->and(AlertRuleOperator::LessThan->evaluate(3, 5))->toBeTrue()
        ->and(AlertRuleOperator::LessThan->evaluate(5, 3))->toBeFalse()
        ->and(AlertRuleOperator::GreaterThanOrEqual->evaluate(5, 5))->toBeTrue()
        ->and(AlertRuleOperator::LessThanOrEqual->evaluate(5, 5))->toBeTrue()
        ->and(AlertRuleOperator::Equal->evaluate(5, 5))->toBeTrue()
        ->and(AlertRuleOperator::Equal->evaluate(5, 6))->toBeFalse();
});
