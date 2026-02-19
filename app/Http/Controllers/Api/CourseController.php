<?php
// app/Http/Controllers/Api/CourseController.php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\CourseResource;
use App\Models\Course;
use App\Traits\ApiResponseTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CourseController extends Controller
{
    use ApiResponseTrait;

    public function index(Request $request)
    {
        $query = Course::with(['instructor'])
                      ->withCount(['lessons', 'students', 'reviews'])
                      ->withAvg('reviews', 'rating');

        // Search by title
        if ($request->has('search')) {
            $query->where('title', 'LIKE', '%' . $request->search . '%');
        }

        // Filter by level
        if ($request->has('level') && in_array($request->level, ['beginner', 'intermediate', 'advanced'])) {
            $query->where('level', $request->level);
        }

        // Price filter
        if ($request->has('min_price')) {
            $query->where('price', '>=', $request->min_price);
        }
        if ($request->has('max_price')) {
            $query->where('price', '<=', $request->max_price);
        }

        // Sorting
        $sortField = $request->get('sort_by', 'created_at');
        $sortOrder = $request->get('sort_order', 'desc');
        $query->orderBy($sortField, $sortOrder);

        $courses = $query->paginate($request->get('per_page', 10));

        return CourseResource::collection($courses);
    }

    public function store(Request $request)
    {
        if (!in_array(auth()->user()->role, ['admin', 'instructor'])) {
            return $this->errorResponse('Unauthorized', 403);
        }

        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'level' => 'required|in:beginner,intermediate,advanced'
        ]);

        if ($validator->fails()) {
            return $this->errorResponse('Validation Error', 422, $validator->errors());
        }

        $course = Course::create([
            'title' => $request->title,
            'description' => $request->description,
            'price' => $request->price,
            'level' => $request->level,
            'instructor_id' => auth()->id()
        ]);

        return $this->successResponse(
            new CourseResource($course->load('instructor')),
            'Course created successfully',
            201
        );
    }

    public function show(Course $course)
    {
        $course->load(['instructor', 'lessons', 'reviews.user'])
               ->loadCount(['students', 'lessons'])
               ->loadAvg('reviews', 'rating');

        return $this->successResponse(new CourseResource($course));
    }

    public function update(Request $request, Course $course)
    {
        if (!auth()->user()->isAdmin() && auth()->id() !== $course->instructor_id) {
            return $this->errorResponse('Unauthorized', 403);
        }

        $validator = Validator::make($request->all(), [
            'title' => 'sometimes|string|max:255',
            'description' => 'sometimes|string',
            'price' => 'sometimes|numeric|min:0',
            'level' => 'sometimes|in:beginner,intermediate,advanced'
        ]);

        if ($validator->fails()) {
            return $this->errorResponse('Validation Error', 422, $validator->errors());
        }

        $course->update($request->only(['title', 'description', 'price', 'level']));

        return $this->successResponse(
            new CourseResource($course->load('instructor')),
            'Course updated successfully'
        );
    }

    public function destroy(Course $course)
    {
        if (!auth()->user()->isAdmin() && auth()->id() !== $course->instructor_id) {
            return $this->errorResponse('Unauthorized', 403);
        }

        $course->delete();
        return $this->successResponse(null, 'Course deleted successfully');
    }
}