<?php

namespace App\Enums;

enum TaskStatusEnum: string
{
    case Pending = 'pending';
    case Completed = 'completed';
    case Canceled = 'canceled';

    public function getLabel(): string
    {
        return match ($this) {
            self::Pending => 'Pending',
            self::Completed => 'Completed',
            self::Canceled => 'Canceled',
        };
    }

    public static function getObj(string $status): TaskStatusEnum|null
    {
        return match ($status) {
            'pending' => self::Pending,
            'completed' => self::Completed,
            'canceled' => self::Canceled,
            default => null,
        };
    }
}
