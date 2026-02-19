<?php
// database/seeders/UserSeeder.php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Admin
        User::create([
            'name' => 'Admin User',
            'email' => 'admin@edtech.com',
            'password' => Hash::make('password'),
            'role' => 'admin'
        ]);

        // Instructor
        $instructor = User::create([
            'name' => 'John Instructor',
            'email' => 'instructor@edtech.com',
            'password' => Hash::make('password'),
            'role' => 'instructor'
        ]);

        // Student
        User::create([
            'name' => 'Jane Student',
            'email' => 'student@edtech.com',
            'password' => Hash::make('password'),
            'role' => 'student'
        ]);
    }
}