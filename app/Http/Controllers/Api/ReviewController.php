<?php
// app/Http/Controllers/Api/ReviewController.php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ReviewResource;
use App\Models\Course;
use App\Models\Review;
use App\Traits\ApiResponseTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ReviewController extends Controller
{
    use ApiResponseTrait;

    public function index(Course $course)
    {
        $reviews = $course->reviews()->with('user')->latest()->get();
        return ReviewResource::collection($reviews);
    }

    public function store(Request $request, Course $course)
    {
        if (!auth()->user()->isStudent()) {
            return $this->errorResponse('Only students can review courses', 403);
        }

        // Check if enrolled
        if (!$course->isEnrolledBy(auth()->id())) {
            return $this->errorResponse('You must be enrolled to review this course', 403);
        }

        // Check if already reviewed
        if ($course->reviews()->where('user_id', auth()->id())->exists()) {
            return $this->errorResponse('You have already reviewed this course', 400);
        }

        $validator = Validator::make($request->all(), [
            'rating' => 'required|integer|between:1,5',
            'comment' => 'nullable|string|max:1000'
        ]);

        if ($validator->fails()) {
            return $this->errorResponse('Validation Error', 422, $validator->errors());
        }

        $review = Review::create([
            'user_id' => auth()->id(),
            'course_id' => $course->id,
            'rating' => $request->rating,
            'comment' => $request->comment
        ]);

        return $this->successResponse(
            new ReviewResource($review->load('user')),
            'Review added successfully',
            201
        );
    }
}