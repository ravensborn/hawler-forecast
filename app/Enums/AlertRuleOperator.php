<?php

namespace App\Enums;

enum AlertRuleOperator: string
{
    case GreaterThan = 'gt';
    case LessThan = 'lt';
    case GreaterThanOrEqual = 'gte';
    case LessThanOrEqual = 'lte';
    case Equal = 'eq';

    public function evaluate(float $value, float $threshold): bool
    {
        return match ($this) {
            self::GreaterThan => $value > $threshold,
            self::LessThan => $value < $threshold,
            self::GreaterThanOrEqual => $value >= $threshold,
            self::LessThanOrEqual => $value <= $threshold,
            self::Equal => $value == $threshold,
        };
    }
}
