<?php

namespace Database\Factories;

use App\Enums\MapPinType;
use App\Enums\Severity;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\MapPin>
 */
class MapPinFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'icon' => $this->faker->randomElement(['weather-station', 'alert-triangle', 'cloud', 'thermometer']),
            'latitude' => $this->faker->latitude(34.5, 37.5),
            'longitude' => $this->faker->longitude(43.0, 46.5),
            'type' => $this->faker->randomElement(MapPinType::cases()),
            'data' => ['info' => $this->faker->sentence()],
            'expires_at' => null,
        ];
    }

    public function weatherStation(): static
    {
        return $this->state(fn () => [
            'icon' => 'weather-station',
            'type' => MapPinType::WeatherStation,
            'data' => [
                'stationName' => $this->faker->city(),
                'status' => 'active',
                'lastReading' => $this->faker->randomFloat(1, -10, 50),
            ],
        ]);
    }

    public function alert(): static
    {
        return $this->state(fn () => [
            'icon' => 'alert-triangle',
            'type' => MapPinType::Alert,
            'data' => [
                'severity' => $this->faker->randomElement(Severity::cases()),
                'message' => [
                    'en' => $this->faker->sentence(),
                    'ar' => $this->faker->sentence(),
                    'ku' => $this->faker->sentence(),
                ],
            ],
            'expires_at' => now()->addDays($this->faker->numberBetween(1, 7)),
        ]);
    }

    public function incident(): static
    {
        return $this->state(fn () => [
            'icon' => 'incident',
            'type' => MapPinType::Incident,
            'data' => [
                'message' => [
                    'en' => $this->faker->sentence(),
                    'ar' => $this->faker->sentence(),
                    'ku' => $this->faker->sentence(),
                ],
            ],
            'expires_at' => now()->addDays($this->faker->numberBetween(1, 7)),
        ]);
    }

    public function expired(): static
    {
        return $this->state(fn () => [
            'expires_at' => now()->subDay(),
        ]);
    }
}
