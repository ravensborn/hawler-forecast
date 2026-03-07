<?php

namespace Database\Factories;

use App\Models\SensorDeviceGroup;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\SensorDevice>
 */
class SensorDeviceFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => [
                'en' => fake()->word(),
                'ar' => fake()->word(),
                'ku' => fake()->word(),
            ],
            'sensor_device_group_id' => SensorDeviceGroup::factory(),
            'platform_device_id' => $this->faker->unique()->uuid(),
        ];
    }
}
