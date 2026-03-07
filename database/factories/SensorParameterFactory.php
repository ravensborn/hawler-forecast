<?php

namespace Database\Factories;

use App\Enums\SensorParameterUnit;
use App\Models\SensorDevice;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\SensorParameter>
 */
class SensorParameterFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name'                 => $this->faker->word(),
            'sensor_device_id'     => SensorDevice::factory(),
            'platform_parameter_id' => $this->faker->unique()->numberBetween(1, 1000),
            'unit'                 => $this->faker->randomElement(SensorParameterUnit::values()),
            'icon'                 => $this->faker->randomElement(['thermometer', 'droplet', 'gauge', 'battery', 'signal']),
        ];
    }
}
