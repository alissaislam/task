<?php

namespace App\Services;

use App\Classes\BaseService;
use App\Repositories\TaskRepository;

class TaskService extends BaseService
{
    public function __construct(
        private readonly TaskRepository $taskRepository,
    )
    {
    }
}