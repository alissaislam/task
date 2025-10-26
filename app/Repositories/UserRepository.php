<?php
namespace App\Repositories;

use App\Models\User;
use App\Enums\UserRole;
use App\Enums\TaskStatus;
use App\Classes\BaseRepository;

class UserRepository extends BaseRepository
{
    protected string $model = User::class;
    public function getUsersWithCompletedTasks(int $perPage = 10)
    {
        return $this->model::where('role', UserRole::USER)
            ->with([
                'tasks' => function ($query) {
                    $query->where('status', TaskStatus::COMPLETED)
                        ->orderBy('due_date', 'desc');
                }
            ])
            ->paginate($perPage);
    }


}
