<?php
// database/migrations/2024_01_01_000001_create_courses_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('courses', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('description');
            $table->decimal('price', 8, 2);
            $table->enum('level', ['beginner', 'intermediate', 'advanced']);
            $table->foreignId('instructor_id')->constrained('users')->onDelete('cascade');
            $table->timestamps();
            
            $table->index(['instructor_id', 'level']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('courses');
    }
};