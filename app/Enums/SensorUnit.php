<?php

namespace App\Enums;

enum SensorUnit: string
{
    case Celsius        = '°C';
    case Humidity       = '%';
    case PartsPerMillion = 'ppm';
    case MicrogramsPerCubicMeter = 'µg/m³';
    case MilligramsPerCubicMeter = 'mg/m³';
}
