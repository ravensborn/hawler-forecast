<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class SensorParameter extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'sensor_device_id',
        'platform_parameter_id',
        'unit',
        'icon',
    ];

    public function sensorDevice(): BelongsTo
    {
        return $this->belongsTo(SensorDevice::class);
    }

    public function telemetries(): HasMany
    {
        return $this->hasMany(Telemetry::class);
    }
}
