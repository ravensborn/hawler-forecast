<?php

namespace App\Models;

use App\Enums\AlertRuleOperator;
use App\Enums\AlertType;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Spatie\Translatable\HasTranslations;

class AlertRule extends Model
{
    /** @use HasFactory<\Database\Factories\AlertRuleFactory> */
    use HasFactory;

    use HasTranslations;

    protected $fillable = [
        'name',
        'operator',
        'threshold',
        'cooldown_hours',
        'should_notify',
        'alert_icon',
        'alert_title',
        'alert_description',
        'alert_type',
    ];

    public array $translatable = ['alert_title', 'alert_description'];

    protected function casts(): array
    {
        return [
            'operator' => AlertRuleOperator::class,
            'threshold' => 'float',
            'cooldown_hours' => 'integer',
            'should_notify' => 'boolean',
            'alert_type' => AlertType::class,
        ];
    }

    public function sensorParameters(): BelongsToMany
    {
        return $this->belongsToMany(SensorParameter::class);
    }

    public function alerts(): HasMany
    {
        return $this->hasMany(Alert::class);
    }

    public function isOnCooldown(): bool
    {
        return $this->alerts()
            ->where('created_at', '>=', now()->subHours($this->cooldown_hours))
            ->exists();
    }

    public function evaluate(float $value): bool
    {
        return $this->operator->evaluate($value, $this->threshold);
    }
}
