<?php

namespace App\Enums;

enum Severity: string
{
    case Low = 'low';
    case Medium = 'medium';
    case High = 'high';

    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }

    public static function exists(string $value): bool
    {
        return in_array($value, self::values());
    }
}
