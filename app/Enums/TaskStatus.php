<?php

namespace App\Enums;
use App\Traits\Arrayable;

enum TaskStatus: string
{
    use Arrayable;

    case COMPLETED = 'COMPLETED';
    case IN_PROGRESS = 'IN_PROGRESS';
    case PENDING = 'PENDING';

    public function label(): string
    {
        return match($this) {
            self::PENDING => 'Pending',
            self::IN_PROGRESS => 'In Progress',
            self::COMPLETED => 'Completed',
        };
    }

    public function color(): string
    {
        return match($this) {
            self::PENDING => 'warning',
            self::IN_PROGRESS => 'info',
            self::COMPLETED => 'success',
        };
    }
}

