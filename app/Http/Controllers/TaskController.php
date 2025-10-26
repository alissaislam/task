<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\SaveTaskRequest;
use App\Services\TaskService;
use App\Enums\TaskStatus;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class TaskController extends Controller
{
    public function __construct(
        private readonly TaskService $taskService
    )
    {
    }

    /**
     * Display a listing of the tasks.
     */
    public function index(): View
    {
        $userId = auth()->id();
        $tasks = $this->taskService->getUserTasks($userId);
        $stats = $this->taskService->getUserTaskStats($userId);

        return view('user.tasks.index', compact('tasks', 'stats'));
    }

    /**
     * Show the form for creating a new task.
     */
    public function create(): View
    {
        $statuses = TaskStatus::cases();
        return view('user.tasks.create', compact('statuses'));
    }

    /**
     * Store a newly created task in storage.
     */
    public function store(SaveTaskRequest $request): RedirectResponse // Updated to SaveTaskRequest
    {
        $userId = auth()->id();
        $this->taskService->createTask($request->validated(), $userId);

        return redirect()->route('user.tasks.index')
            ->with('success', 'Task created successfully!');
    }

    /**
     * Display the specified task.
     */
    public function show(int $id): View
    {
        $userId = auth()->id();
        $task = $this->taskService->getUserTask($id, $userId);

        if (!$task) {
            abort(404, 'Task not found.');
        }

        return view('user.tasks.show', compact('task'));
    }

    /**
     * Show the form for editing the specified task.
     */
    public function edit(int $id): View
    {
        $userId = auth()->id();
        $task = $this->taskService->getUserTask($id, $userId);
        $statuses = TaskStatus::cases();

        if (!$task) {
            abort(404, 'Task not found.');
        }

        return view('user.tasks.edit', compact('task', 'statuses'));
    }

    /**
     * Update the specified task in storage.
     */
    public function update(SaveTaskRequest $request, int $id): RedirectResponse // Updated to SaveTaskRequest
    {
        $userId = auth()->id();
        $task = $this->taskService->updateTask($id, $userId, $request->validated());

        if (!$task) {
            abort(404, 'Task not found.');
        }

        return redirect()->route('user.tasks.index')
            ->with('success', 'Task updated successfully!');
    }

    /**
     * Remove the specified task from storage.
     */
    public function destroy(int $id): RedirectResponse
    {
        $userId = auth()->id();
        $deleted = $this->taskService->deleteTask($id, $userId);

        if (!$deleted) {
            abort(404, 'Task not found.');
        }

        return redirect()->route('user.tasks.index')
            ->with('success', 'Task deleted successfully!');
    }
}