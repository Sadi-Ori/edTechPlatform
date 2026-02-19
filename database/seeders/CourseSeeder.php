<?php
// database/seeders/CourseSeeder.php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Course;
use App\Models\User;

class CourseSeeder extends Seeder
{
    public function run(): void
    {
        // Instructor Search
        $instructor = User::where('role', 'instructor')->first();
        
        if (!$instructor) {
            $instructor = User::create([
                'name' => 'Default Instructor',
                'email' => 'default.instructor@edtech.com',
                'password' => bcrypt('password'),
                'role' => 'instructor'
            ]);
        }

        // Course 1: Beginner PHP Course
        Course::create([
            'title' => 'Complete PHP Course for Beginners',
            'description' => 'Learn PHP from scratch! This comprehensive course covers all PHP fundamentals including variables, arrays, functions, OOP, MySQL integration, and building dynamic websites. Perfect for absolute beginners.',
            'price' => 49.99,
            'level' => 'beginner',
            'instructor_id' => $instructor->id
        ]);

        // Course 2: Advanced Laravel Course
        Course::create([
            'title' => 'Master Laravel 10 - Advanced Topics',
            'description' => 'Take your Laravel skills to the next level! Learn advanced concepts like service containers, facades, queues, events, broadcasting, API development, testing, and deployment strategies.',
            'price' => 79.99,
            'level' => 'advanced',
            'instructor_id' => $instructor->id
        ]);

        //  Course 3: JavaScript & Vue.js Course
        Course::create([
            'title' => 'Modern JavaScript with Vue.js',
            'description' => 'Master modern JavaScript (ES6+) and Vue.js framework. Build reactive single-page applications, understand components, Vuex state management, routing, and integrate with backend APIs.',
            'price' => 59.99,
            'level' => 'intermediate',
            'instructor_id' => $instructor->id
        ]);
    }
}