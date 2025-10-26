<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Enums\UserRole;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create admin user
        User::create([
            'name' => 'System Administrator',
            'email' => 'admin@taskmanager.com',
            'password' => Hash::make('admin123'),
            'role' => UserRole::ADMIN,
        ]);

        // Create regular users
        User::create([
            'name' => 'Islam Al-issa',
            'email' => 'islam.alissa2002@gmail.com',
            'password' => Hash::make('password'),
            'role' => UserRole::USER,
        ]);

        User::create([
            'name' => 'Jane Smith',
            'email' => 'jane@example.com',
            'password' => Hash::make('password'),
            'role' => UserRole::USER,
        ]);

        // Create more test users
        User::factory(3)->create();
    }
}