<?php

namespace App\Enums;
use App\Traits\Arrayable;

enum UserRole: string
{
    use Arrayable;

    case USER = 'USER';
    case ADMIN = 'ADMIN';
}

