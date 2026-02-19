<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    public function run(): void
    {
        // Create admin
        User::create([
            'name' => 'Admin User',
            'email' => 'admin@edtech.com',
            'password' => Hash::make('Admin@123'),
            'role' => 'admin'
        ]);

        // Create instructor
        User::create([
            'name' => 'Instructor01',
            'email' => 'instructor01@edtech.com',
            'password' => Hash::make('Instructor01@123'),
            'role' => 'instructor'
        ]);

        // Create student
        User::create([
            'name' => 'Student01',
            'email' => 'student01@edtech.com',
            'password' => Hash::make('Student01@123'),
            'role' => 'student'
        ]);

        // Create 50 random users
        User::factory()->count(50)->create();
    }
}