@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-4xl mx-auto">
        <!-- Welcome Message -->
        <div class="bg-white rounded-lg shadow-md p-8 text-center">
            <div class="mb-6">
                <svg class="w-16 h-16 text-blue-500 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                <h1 class="text-3xl font-bold text-gray-800 mb-2">
                    Welcome to Task Manager, {{ Auth::user()->name }}!
                </h1>
                <p class="text-gray-600 text-lg">
                    You have successfully logged in to your Task Management System.
                </p>
            </div>
            
            <div class="mt-6">
                <p class="text-gray-500">
                    Ready to manage your tasks? The full dashboard features will be available soon.
                </p>
            </div>
        </div>
    </div>
</div>
@endsection