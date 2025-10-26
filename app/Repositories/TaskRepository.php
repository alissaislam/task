<?php
namespace App\Repositories;

use App\Models\Task;
use App\Classes\BaseRepository;

class TaskRepository extends BaseRepository
{
    protected string $model = Task::class;

      public function getUserTasksPaginated(int $userId, int $perPage = 10)
    {
        return $this->model::where('user_id', $userId)
            ->orderBy('due_date', 'asc')
            ->paginate($perPage);
    }
}
