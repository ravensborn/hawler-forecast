<?php

namespace App\Enums;

enum SensorParameterUnit: string
{
    case Celsius = '°C';
    case RelativeHumidity = '%';
    case Kilograms = 'kg';
    case PartsPerMillion = 'ppm';
    case PartsPerBillion = 'ppb';
    case MicrogramsPerCubicMeter = 'µg/m³';
    case MilligramsPerCubicMeter = 'mg/m³';
    case Millimeters = 'mm';
    case Hectopascal = 'hPa';
    case GravitationalAcceleration = 'g';
    case Degrees = '°';
    case Meters = 'm';
    case NoUnit = '-';

    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }

    public static function exists(string $value): bool
    {
        return in_array($value, self::values());
    }
}
