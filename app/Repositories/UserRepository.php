<?php
namespace App\Repositories;

use App\Models\User;
use App\Classes\BaseRepository;

class UserRepository extends BaseRepository
{
    protected string $model = User::class;
    //  public function save(array $data): User
    // {
    //     \DB::beginTransaction();
    //     $id = isset($data['id']) ? $data['id'] : NULL;
    //     $data = Arr::except($data, 'id');
    //     $user = $this->model::updateOrCreate([
    //         'id' => $id,
    //     ], $data);

    //     \DB::commit();

    //     return $user;
    // }

}
