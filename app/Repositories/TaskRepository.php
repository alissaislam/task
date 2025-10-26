<?php
namespace App\Repositories;

use App\Models\Task;
use App\Classes\BaseRepository;

class TaskRepository extends BaseRepository
{
    protected string $model = Task::class;
}
