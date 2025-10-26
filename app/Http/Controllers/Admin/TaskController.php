<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\TaskResource;
use App\Services\AdminService;
use Illuminate\Http\JsonResponse;
use App\Traits\ApiResponse;

class TaskController extends Controller
{
    use ApiResponse;

    public function __construct(
        private readonly AdminService $adminService
    )
    {
    }

    /**
     * Get all tasks (cached for 60 seconds)
     */
    public function index(): JsonResponse
    {
        $tasks = $this->adminService->getAllTasks();

        return $this->successResponse(
            TaskResource::collection($tasks),
            'Tasks retrieved successfully',
            200
        );
    }

    /**
     * Get task details
     */
    public function show(int $id): JsonResponse
    {
        $task = $this->adminService->getTask($id);

        if (!$task) {
            return $this->errorResponse('Task not found.', 404);
        }

        return $this->successResponse(
            new TaskResource($task->load('user')),
            'Task retrieved successfully',
            200
        );
    }

    /**
     * Delete a task
     */
    public function destroy(int $id): JsonResponse
    {
        $deleted = $this->adminService->deleteTask($id);

        if (!$deleted) {
            return $this->errorResponse('Task not found.', 404);
        }

        return $this->successResponse(null, 'Task deleted successfully.', 200);
    }
}