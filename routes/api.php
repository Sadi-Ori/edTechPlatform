<?php
// routes/api.php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\CourseController;
use App\Http\Controllers\Api\LessonController;
use App\Http\Controllers\Api\EnrollmentController;
use App\Http\Controllers\Api\ReviewController;

// Public routes
Route::prefix('auth')->group(function () {
    Route::post('register', [AuthController::class, 'register']);
    Route::post('login', [AuthController::class, 'login']);
});

// Public course listing
Route::get('courses', [CourseController::class, 'index']);
Route::get('courses/{course}', [CourseController::class, 'show']);
Route::get('courses/{course}/lessons', [LessonController::class, 'index']);
Route::get('courses/{course}/reviews', [ReviewController::class, 'index']);

// Protected routes
Route::middleware(['jwt.auth'])->group(function () {
    // Auth
    Route::prefix('auth')->group(function () {
        Route::post('logout', [AuthController::class, 'logout']);
        Route::post('refresh', [AuthController::class, 'refresh']);
        Route::get('me', [AuthController::class, 'me']);
    });

    // Courses (instructor/admin only)
    Route::middleware(['role:admin,instructor'])->group(function () {
        Route::post('courses', [CourseController::class, 'store']);
        Route::put('courses/{course}', [CourseController::class, 'update']);
        Route::delete('courses/{course}', [CourseController::class, 'destroy']);
        
        // Lessons
        Route::post('courses/{course}/lessons', [LessonController::class, 'store']);
        Route::put('lessons/{lesson}', [LessonController::class, 'update']);
        Route::delete('lessons/{lesson}', [LessonController::class, 'destroy']);
    });

    // Enrollments (students only)
    Route::middleware(['role:student'])->group(function () {
        Route::post('courses/{course}/enroll', [EnrollmentController::class, 'enroll']);
        Route::get('my-courses', [EnrollmentController::class, 'myCourses']);
        Route::post('courses/{course}/reviews', [ReviewController::class, 'store']);
    });
});