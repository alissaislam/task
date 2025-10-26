<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Task;
use App\Models\User;
use App\Enums\TaskStatus;
use App\Enums\UserRole;

class TaskSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = User::where('role', UserRole::USER)->get();
        
        $statuses = [TaskStatus::PENDING, TaskStatus::IN_PROGRESS, TaskStatus::COMPLETED];
        
        foreach ($users as $user) {
            for ($i = 1; $i <= 5; $i++) {
                Task::create([
                    'user_id' => $user->id,
                    'title' => "Task {$i} for {$user->name}",
                    'description' => "This is task number {$i} description for {$user->name}.",
                    'status' => $statuses[array_rand($statuses)],
                    'due_date' => now()->addDays(rand(1, 30)),
                ]);
            }
        }
    }
}