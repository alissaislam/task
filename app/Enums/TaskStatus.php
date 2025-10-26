<?php

namespace App\Enums;
use App\Traits\Arrayable;

enum TaskStatus: string
{
    use Arrayable;

    case COMPLETED = 'COMPLETED';
    case IN_PROGRESS = 'IN_PROGRESS';
    case PENDING = 'PENDING';
}

