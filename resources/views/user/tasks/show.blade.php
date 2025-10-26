@extends('layouts.app')

@section('content')
    <div class="container mx-auto px-4 py-8">
        <div class="max-w-2xl mx-auto">
            <div class="flex justify-between items-center mb-6">
                <h1 class="text-3xl font-bold text-gray-800">Task Details</h1>
                <div class="flex space-x-2">
                    <a href="{{ route('user.tasks.edit', $task->id) }}"
                        class="bg-green-500 hover:bg-green-600 text-white px-4 py-2 rounded-md">
                        Edit
                    </a>
                    <a href="{{ route('user.tasks.index') }}"
                        class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-md">
                        Back to List
                    </a>
                </div>
            </div>

            <div class="bg-white rounded-lg shadow-md p-6">
                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2">Title</label>
                    <p class="text-lg text-gray-900">{{ $task->title }}</p>
                </div>

                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2">Description</label>
                    <p class="text-gray-900 whitespace-pre-wrap">{{ $task->description ?: 'No description provided.' }}</p>
                </div>

                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2">Status</label>

                    <span
                        class="px-3 py-1 inline-flex text-sm leading-5 font-semibold rounded-full 
    @if ($task->status === \App\Enums\TaskStatus::PENDING) bg-yellow-100 text-yellow-800
    @elseif($task->status === \App\Enums\TaskStatus::IN_PROGRESS) bg-blue-100 text-blue-800
    @else bg-green-100 text-green-800 @endif">
                        {{ $task->status->label() }}
                    </span>
                    @if ($task->isOverdue())
                        <span
                            class="ml-2 px-3 py-1 inline-flex text-sm leading-5 font-semibold rounded-full bg-red-100 text-red-800">
                            Overdue
                        </span>
                    @endif
                </div>

                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2">Due Date</label>
                    <p class="text-gray-900">{{ $task->due_date->format('F d, Y') }}</p>
                    @if ($task->isOverdue())
                        <p class="text-red-600 text-sm mt-1">This task is overdue by
                            {{ $task->due_date->diffInDays(now()) }} days</p>
                    @elseif($task->due_date->isToday())
                        <p class="text-orange-600 text-sm mt-1">Due today!</p>
                    @else
                        <p class="text-gray-600 text-sm mt-1">{{ $task->due_date->diffForHumans() }}</p>
                    @endif
                </div>

                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2">Created</label>
                    <p class="text-gray-900">{{ $task->created_at->format('F d, Y \a\t g:i A') }}</p>
                </div>

                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2">Last Updated</label>
                    <p class="text-gray-900">{{ $task->updated_at->format('F d, Y \a\t g:i A') }}</p>
                </div>

                <div class="mt-6 pt-6 border-t border-gray-200">
                    <form action="{{ route('user.tasks.destroy', $task->id) }}" method="POST" class="inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded-md"
                            onclick="return confirm('Are you sure you want to delete this task? This action cannot be undone.')">
                            Delete Task
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
