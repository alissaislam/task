<?php

namespace App\Services;

use App\Models\Task;
use App\Models\User;
use App\Enums\UserRole;
use App\Classes\BaseService;
use App\Repositories\TaskRepository;
use App\Repositories\UserRepository;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Cache;
use Illuminate\Database\Eloquent\Collection;

class AdminService extends BaseService
{
    public function __construct(
        private readonly UserRepository $userRepository,
        private readonly TaskRepository $taskRepository,
    ) {
    }

    /**
     * Authenticate admin user
     */
    public function authenticate(array $credentials)
    {
        $user = $this->userRepository->firstWhere([
            'email' => $credentials['email'],
            'role' => UserRole::ADMIN
        ]);

        if (!$user || !Hash::check($credentials['password'], $user->password)) {
            return null;
        }

        return $user;
    }

    /**
     * Get all users (excluding admins)
     */
    public function getAllUsers(): Collection
    {
        return $this->userRepository->findWhere([
            'role' => UserRole::USER
        ]);
    }

    /**
     * Delete a user
     */
    public function deleteUser(int $userId): bool
    {
        $user = $this->userRepository->find($userId);

        if (!$user || $user->role === UserRole::ADMIN) {
            return false;
        }

        // Delete user's tasks first
        $user->tasks()->delete();

        return $this->userRepository->delete($userId);
    }

    /**
     * Get all tasks with caching
     */
    public function getAllTasks(): Collection
    {
        return Cache::remember('admin_tasks', 60, function () {
            return $this->taskRepository->all()->load('user');
        });
    }

    /**
     * Get task details
     */
    public function getTask(int $taskId): ?Task
    {
        return $this->taskRepository->find($taskId);
    }

    /**
     * Delete a task
     */
    public function deleteTask(int $taskId): bool
    {
        // Clear cache when task is deleted
        Cache::forget('admin_tasks');
        return $this->taskRepository->delete($taskId);
    }

    /**
     * Clear tasks cache
     */
    public function clearTasksCache(): void
    {
        Cache::forget('admin_tasks');
    }

    public function getCompletedTasksReport(int $perPage = 10): array
    {
        $usersPaginator = $this->userRepository->getUsersWithCompletedTasks($perPage);

        $transformedData = $usersPaginator->getCollection()
            ->filter(fn($user) => $user->tasks->isNotEmpty())
            ->map(fn($user) => $this->buildUserReport($user));

        return [
            'data' => $usersPaginator->setCollection($transformedData),
            'pagination' => [
                    'total' => $transformedData->count(),
                ]
        ];
    }

    /**
     * Build user report data
     */
    private function buildUserReport(User $user): array
    {
        return [
            'user_id' => $user->id,
            'user_name' => $user->name,
            'user_email' => $user->email,
            'completed_tasks_count' => $user->tasks->count(),
            'completed_tasks' => $user->tasks->map(fn($task) => $this->buildTaskData($task))
        ];
    }

    /**
     * Build task data for report
     */
    private function buildTaskData(Task $task): array
    {
        return [
            'task_id' => $task->id,
            'title' => $task->title,
            'description' => $task->description,
            'due_date' => $task->due_date->format('Y-m-d'),
            'completed_at' => $task->updated_at->format('Y-m-d H:i:s'),
            'days_to_complete' => $task->created_at->diffInDays($task->updated_at),
        ];
    }
}