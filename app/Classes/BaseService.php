<?php

namespace App\Classes;

use Illuminate\Support\Str;
use Illuminate\Support\Traits\ForwardsCalls;

class BaseService
{
    use ForwardsCalls;
    public function __call(string $name, array $arguments)
    {
        $repository_class = Str::replace("Services", "Repositories", static::class);
        $repository_class = Str::replace("Service", "Repository", $repository_class);
        if (class_exists($repository_class)) {
            if (method_exists($repository_class, $name)) {
                $object = app($repository_class);
                return $this->forwardCallTo($object, $name, $arguments);
            }
        }

        throw new \BadMethodCallException("Method ($name) does not exist in class ($repository_class)");
    }
}