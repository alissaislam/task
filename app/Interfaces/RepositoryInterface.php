<?php

namespace App\Interfaces;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

interface RepositoryInterface
{
    public function save(array $data): Model;

    public function delete(int $id): bool;

    public function find(int $id): ?Model;

    public function findWhere(array $criteria): Collection;

    public function all(): Collection;

    public function forceDelete(int $id): bool;

}