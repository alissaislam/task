<?php

namespace App\Traits;

trait Arrayable {
    public static function toArray() : array {
        return array_column(static::cases(), 'value');
    }
}