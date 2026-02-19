<?php
// app/Http/Controllers/Api/EnrollmentController.php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\CourseResource;
use App\Models\Course;
use App\Models\Enrollment;
use App\Traits\ApiResponseTrait;
use Illuminate\Http\Request;

class EnrollmentController extends Controller
{
    use ApiResponseTrait;

    public function enroll(Course $course)
    {
        if (!auth()->user()->isStudent()) {
            return $this->errorResponse('Only students can enroll in courses', 403);
        }

        // Check if already enrolled
        if ($course->isEnrolledBy(auth()->id())) {
            return $this->errorResponse('Already enrolled in this course', 400);
        }

        Enrollment::create([
            'user_id' => auth()->id(),
            'course_id' => $course->id,
            'enrolled_at' => now(),
            'status' => 'active'
        ]);

        return $this->successResponse(null, 'Successfully enrolled in course');
    }

    public function myCourses(Request $request)
    {
        $user = auth()->user();
        
        $courses = $user->enrollments()
                       ->with(['instructor'])
                       ->withCount(['lessons', 'reviews'])
                       ->withAvg('reviews', 'rating')
                       ->paginate($request->get('per_page', 10));

        return CourseResource::collection($courses);
    }
}