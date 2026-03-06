<?php

namespace App\Enums;

enum MapPinType: string
{
    case WeatherStation = 'weather-station';
    case Alert = 'alert';
    case Incident = 'incident';

    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }

    public static function exists(string $value): bool
    {
        return in_array($value, self::values());
    }
}
