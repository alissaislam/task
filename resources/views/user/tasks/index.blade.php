@extends('layouts.app')

@section('content')
    <div class="container mx-auto px-4 py-8">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-3xl font-bold text-gray-800">My Tasks</h1>
            <a href="{{ route('user.tasks.create') }}" class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-md">
                Create New Task
            </a>
        </div>

        <!-- Statistics -->
        <div class="grid grid-cols-1 md:grid-cols-5 gap-4 mb-8">
            <div class="bg-white rounded-lg shadow p-4">
                <div class="text-2xl font-bold text-blue-600">{{ $stats['total'] }}</div>
                <div class="text-gray-600">Total Tasks</div>
            </div>
            <div class="bg-white rounded-lg shadow p-4">
                <div class="text-2xl font-bold text-yellow-600">{{ $stats['pending'] }}</div>
                <div class="text-gray-600">Pending</div>
            </div>
            <div class="bg-white rounded-lg shadow p-4">
                <div class="text-2xl font-bold text-orange-600">{{ $stats['in_progress'] }}</div>
                <div class="text-gray-600">In Progress</div>
            </div>
            <div class="bg-white rounded-lg shadow p-4">
                <div class="text-2xl font-bold text-green-600">{{ $stats['completed'] }}</div>
                <div class="text-gray-600">Completed</div>
            </div>
            <div class="bg-white rounded-lg shadow p-4">
                <div class="text-2xl font-bold text-red-600">{{ $stats['overdue'] }}</div>
                <div class="text-gray-600">Overdue</div>
            </div>
        </div>

        <!-- Tasks List -->
        <div class="bg-white rounded-lg shadow overflow-hidden">
            @if ($tasks->count() > 0)
                <div class="overflow-x-auto">
                    <table class="min-w-full">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Title</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Status</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Due Date</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Actions</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach ($tasks as $task)
                                <tr class="{{ $task->isOverdue() ? 'bg-red-50' : '' }}">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm font-medium text-gray-900">{{ $task->title }}</div>
                                        @if ($task->description)
                                            <div class="text-sm text-gray-500 truncate max-w-xs">{{ $task->description }}
                                            </div>
                                        @endif
                                    </td>
                                    {{-- In the table row --}}
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span
                                            class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
        @if ($task->status === \App\Enums\TaskStatus::PENDING) bg-yellow-100 text-yellow-800
        @elseif($task->status === \App\Enums\TaskStatus::IN_PROGRESS) bg-blue-100 text-blue-800
        @else bg-green-100 text-green-800 @endif">
                                            {{ $task->status->label() }}
                                        </span>
                                        @if ($task->isOverdue())
                                            <span
                                                class="ml-2 px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">
                                                Overdue
                                            </span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                        {{ $task->due_date->format('M d, Y') }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                        <a href="{{ route('user.tasks.show', $task->id) }}"
                                            class="text-blue-600 hover:text-blue-900 mr-3">View</a>
                                        <a href="{{ route('user.tasks.edit', $task->id) }}"
                                            class="text-green-600 hover:text-green-900 mr-3">Edit</a>
                                        <form action="{{ route('user.tasks.destroy', $task->id) }}" method="POST"
                                            class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-600 hover:text-red-900"
                                                onclick="return confirm('Are you sure you want to delete this task?')">
                                                Delete
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="text-center py-8">
                    <p class="text-gray-500">No tasks found. <a href="{{ route('user.tasks.create') }}"
                            class="text-blue-500 hover:text-blue-700">Create your first task!</a></p>
                </div>
            @endif
        </div>
    </div>
@endsection
