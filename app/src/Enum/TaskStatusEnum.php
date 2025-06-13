<?php

namespace App\Enum;

enum TaskStatusEnum: string
{
    case NEW = 'new';
    case PAUSED = 'paused';
    case IN_PROGRESS = 'in_progress';
    case COMPLETED = 'completed';
    case FAILED = 'failed';

    public const STATUS_LIST = [
        self::NEW,
        self::PAUSED,
        self::IN_PROGRESS,
        self::COMPLETED,
        self::FAILED,
    ];

    public function label(): string
    {
        return match($this) {
            self::NEW => 'New',
            self::PAUSED => 'Paused',
            self::IN_PROGRESS => 'In Progress',
            self::COMPLETED => 'Completed',
            self::FAILED => 'Failed',
        };
    }
}
