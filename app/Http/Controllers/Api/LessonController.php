<?php
// app/Http/Controllers/Api/LessonController.php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\LessonResource;
use App\Models\Course;
use App\Models\Lesson;
use App\Traits\ApiResponseTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class LessonController extends Controller
{
    use ApiResponseTrait;

    public function index(Course $course)
    {
        $lessons = $course->lessons()->orderBy('order')->get();
        return LessonResource::collection($lessons);
    }

    public function store(Request $request, Course $course)
    {
        if (!auth()->user()->isAdmin() && auth()->id() !== $course->instructor_id) {
            return $this->errorResponse('Unauthorized', 403);
        }

        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'order' => 'integer|unique:lessons,order,NULL,id,course_id,' . $course->id
        ]);

        if ($validator->fails()) {
            return $this->errorResponse('Validation Error', 422, $validator->errors());
        }

        $lesson = $course->lessons()->create([
            'title' => $request->title,
            'content' => $request->content,
            'order' => $request->order ?? $course->lessons()->max('order') + 1
        ]);

        return $this->successResponse(
            new LessonResource($lesson),
            'Lesson created successfully',
            201
        );
    }

    public function update(Request $request, Lesson $lesson)
    {
        if (!auth()->user()->isAdmin() && auth()->id() !== $lesson->course->instructor_id) {
            return $this->errorResponse('Unauthorized', 403);
        }

        $validator = Validator::make($request->all(), [
            'title' => 'sometimes|string|max:255',
            'content' => 'sometimes|string',
            'order' => 'integer|unique:lessons,order,' . $lesson->id . ',id,course_id,' . $lesson->course_id
        ]);

        if ($validator->fails()) {
            return $this->errorResponse('Validation Error', 422, $validator->errors());
        }

        $lesson->update($request->only(['title', 'content', 'order']));

        return $this->successResponse(
            new LessonResource($lesson),
            'Lesson updated successfully'
        );
    }

    public function destroy(Lesson $lesson)
    {
        if (!auth()->user()->isAdmin() && auth()->id() !== $lesson->course->instructor_id) {
            return $this->errorResponse('Unauthorized', 403);
        }

        $lesson->delete();
        return $this->successResponse(null, 'Lesson deleted successfully');
    }
}