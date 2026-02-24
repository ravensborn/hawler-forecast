<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Spatie\Translatable\HasTranslations;

class SensorDevice extends Model
{
    use HasFactory;
    use HasTranslations;

    protected $fillable = [
        'name',
        'sensor_id',
        'sensor_device_group_id',
        'platform_device_id',
    ];

    public array $translatable = ['name'];

    public function sensor(): BelongsTo
    {
        return $this->belongsTo(Sensor::class);
    }

    public function sensorDeviceGroup(): BelongsTo
    {
        return $this->belongsTo(SensorDeviceGroup::class);
    }

    public function telemetries(): HasMany
    {
        return $this->hasMany(Telemetry::class);
    }

    public function latestTelemetries(): HasMany
    {
        return $this->hasMany(Telemetry::class)
            ->whereIn('id', function ($query) {
                $query->selectRaw('MAX(id)')
                    ->from('telemetries')
                    ->groupBy('sensor_device_id', 'sensor_parameter_id');
            });
    }
}
