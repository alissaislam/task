<?php

namespace App\Services;

use App\Classes\BaseService;
use App\Repositories\TaskRepository;
use App\Models\Task;
use App\Enums\TaskStatus;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Cache;

class TaskService extends BaseService
{
    public function __construct(
        private readonly TaskRepository $taskRepository,
    )
    {
    }

    /**
     * Get all tasks for a specific user
     */
    public function getUserTasks(int $userId): Collection
    {
        return $this->taskRepository->findWhere(['user_id' => $userId]);
    }

    /**
     * Get a specific task for a user
     */
    public function getUserTask(int $taskId, int $userId): ?Task
    {
        return $this->taskRepository->firstWhere([
            'id' => $taskId,
            'user_id' => $userId
        ]);
    }

    /**
     * Create a new task for user
     */
    public function createTask(array $data, int $userId): Task
    {
        $data['user_id'] = $userId;
        
        // Clear admin tasks cache when a new task is created
        Cache::forget('admin_tasks');
        
        return $this->taskRepository->save($data);
    }

    /**
     * Update a user's task
     */
    public function updateTask(int $taskId, int $userId, array $data): ?Task
    {
        $task = $this->getUserTask($taskId, $userId);
        
        if (!$task) {
            return null;
        }

        // Clear admin tasks cache when a task is updated
        Cache::forget('admin_tasks');
        
        return $this->taskRepository->save(array_merge($data, ['id' => $taskId]));
    }

    /**
     * Delete a user's task
     */
    public function deleteTask(int $taskId, int $userId): bool
    {
        $task = $this->getUserTask($taskId, $userId);
        
        if (!$task) {
            return false;
        }

        // Clear admin tasks cache when a task is deleted
        Cache::forget('admin_tasks');
        
        return $this->taskRepository->delete($taskId);
    }

    /**
     * Get task statistics for user
     */
    public function getUserTaskStats(int $userId): array
    {
        $tasks = $this->getUserTasks($userId);
        
        return [
            'total' => $tasks->count(),
            'pending' => $tasks->where('status', TaskStatus::PENDING)->count(),
            'in_progress' => $tasks->where('status', TaskStatus::IN_PROGRESS)->count(),
            'completed' => $tasks->where('status', TaskStatus::COMPLETED)->count(),
            'overdue' => $tasks->filter(function($task) {
                return $task->isOverdue();
            })->count(),
        ];
    }
}