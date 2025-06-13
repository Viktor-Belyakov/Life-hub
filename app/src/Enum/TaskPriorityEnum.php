<?php

namespace App\Enum;

enum TaskPriorityEnum: string
{
    case LOW = 'low';
    case MEDIUM = 'medium';
    case HIGH = 'high';

    public const PRIORITY_LIST = [
        self::LOW,
        self::MEDIUM,
        self::HIGH,
    ];

    public function label(): string
    {
        return match($this) {
            self::LOW => 'Low',
            self::MEDIUM => 'Medium',
            self::HIGH => 'High',
        };
    }
}
