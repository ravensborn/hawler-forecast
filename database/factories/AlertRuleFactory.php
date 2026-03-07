<?php

namespace Database\Factories;

use App\Enums\AlertRuleOperator;
use App\Enums\AlertType;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\AlertRule>
 */
class AlertRuleFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->words(3, true),
            'operator' => AlertRuleOperator::GreaterThan,
            'threshold' => fake()->randomFloat(2, 10, 100),
            'cooldown_hours' => 6,
            'should_notify' => false,
            'alert_icon' => 'warning',
            'alert_title' => [
                'en' => fake()->sentence(3),
                'ar' => fake()->sentence(3),
                'ku' => fake()->sentence(3),
            ],
            'alert_description' => [
                'en' => fake()->sentence(),
                'ar' => fake()->sentence(),
                'ku' => fake()->sentence(),
            ],
            'alert_type' => AlertType::Warning,
        ];
    }
}
