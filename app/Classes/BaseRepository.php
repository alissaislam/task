<?php

namespace App\Classes;

use Abbasudo\Purity\Traits\Filterable;
use App\Interfaces\RepositoryInterface;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;

abstract class BaseRepository implements RepositoryInterface
{
    /** @var Model $model */
    protected string $model = Model::class;

    public function save(array $data): Model
    {
        DB::beginTransaction();
        $id = isset($data['id']) ? $data['id'] : NULL;
        $data = Arr::except($data, 'id');
        $model = $this->model::updateOrCreate([
            'id' => $id,
        ], $data);

        DB::commit();

        return $model;
    }

    public function delete(int $id): bool
    {
        return $this->find($id)->delete();
    }

    public function find(int $id): ?Model
    {
        return $this->model::find($id);
    }

    public function findOrFail(int $id): ?Model
    {
        return $this->model::findOrFail($id);
    }

    public function findWhere(array $criteria): Collection
    {
        return $this->model::where($criteria)->get();
    }

    public function firstWhere(array $criteria): ?Model
    {
        return $this->model::firstWhere($criteria);
    }

    public function all(): Collection
    {
        return $this->model::all();
    }

    public function forceDelete(int $id): bool
    {
        return $this->model::find($id)->forceDelete();
    }

    public function findWhereIn(string $field, array $values): Collection
    {
        return $this->model::whereIn($field, $values)->get();
    }

    public function get(?int $page = 1, ?int $per_page = 10)
    {
        // $class_traits = class_uses_recursive($this->model);
        // if (!in_array(Filterable::class, $class_traits)) {
            return $this->model::paginate(page: $page, perPage: $per_page);
        // }
        // return $this->model::filter()->paginate(page: $page, perPage: $per_page);
    }
}