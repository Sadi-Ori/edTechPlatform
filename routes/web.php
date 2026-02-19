<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// ========== WELCOME PAGE (HOME) ==========

Route::get('/', function () {
    return view('welcome'); 
});

// ========== PUBLIC ROUTES ==========
Route::get('/courses', function () {
    return view('courses.index');
})->name('courses.index');

Route::get('/courses/{id}', function ($id) {
    return view('courses.show', ['id' => $id]);
})->name('courses.show');

Route::get('/login', function () {
    return view('auth.login');
})->name('login');

Route::get('/register', function () {
    return view('auth.register');
})->name('register');

// ========== PROTECTED ROUTES (require authentication) ==========
Route::middleware(['auth'])->group(function () {
    Route::get('/my-courses', function () {
        return view('dashboard.my-courses');
    })->name('my-courses');
    
    Route::get('/instructor/dashboard', function () {
        return view('dashboard.instructor');
    })->name('instructor.dashboard');
    
    Route::get('/courses/create', function () {
        return view('courses.create');
    })->name('courses.create');
});

// ========== API ROUTES (already in api.php) ==========
