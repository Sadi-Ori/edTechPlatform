<?php
// app/Policies/CoursePolicy.php

namespace App\Policies;

use App\Models\User;
use App\Models\Course;

class CoursePolicy
{
    public function create(User $user)
    {
        return $user->isAdmin() || $user->isInstructor();
    }

    public function update(User $user, Course $course)
    {
        return $user->isAdmin() || $user->id === $course->instructor_id;
    }

    public function delete(User $user, Course $course)
    {
        return $user->isAdmin() || $user->id === $course->instructor_id;
    }

    public function enroll(User $user, Course $course)
    {
        return $user->isStudent() && 
               !$user->enrollments()->where('course_id', $course->id)->exists();
    }

    public function review(User $user, Course $course)
    {
        return $user->isStudent() && 
               $user->enrollments()->where('course_id', $course->id)->exists() &&
               !$user->reviews()->where('course_id', $course->id)->exists();
    }
}