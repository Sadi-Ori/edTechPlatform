<?php
// app/Http/Resources/CourseResource.php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CourseResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'description' => $this->description,
            'price' => $this->price,
            'level' => $this->level,
            'instructor' => [
                'id' => $this->instructor->id,
                'name' => $this->instructor->name,
                'email' => $this->instructor->email
            ],
            'total_lessons' => $this->whenLoaded('lessons', function() {
                return $this->lessons->count();
            }, $this->total_lessons),
            'total_students' => $this->total_students,
            'average_rating' => $this->average_rating,
            'is_enrolled' => $this->when(auth()->check(), function() {
                return $this->isEnrolledBy(auth()->id());
            }, false),
            'lessons' => LessonResource::collection($this->whenLoaded('lessons')),
            'reviews' => ReviewResource::collection($this->whenLoaded('reviews')),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at
        ];
    }
}