<?php
// app/Models/Lesson.php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Lesson extends Model
{
    protected $fillable = ['course_id', 'title', 'content', 'order'];

    protected $casts = [
        'order' => 'integer',
    ];

    public function course(): BelongsTo
    {
        return $this->belongsTo(Course::class);
    }

    // Get next lesson
    public function next()
    {
        return $this->course->lessons()
                    ->where('order', '>', $this->order)
                    ->orderBy('order', 'asc')
                    ->first();
    }

    // Get previous lesson
    public function previous()
    {
        return $this->course->lessons()
                    ->where('order', '<', $this->order)
                    ->orderBy('order', 'desc')
                    ->first();
    }
}