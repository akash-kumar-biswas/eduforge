<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Course;

class CourseSeeder extends Seeder
{
    public function run(): void
    {
        // Default course
        Course::create([
            'title' => 'Introduction to Web Development',
            'description' => 'Learn the basics of web development.',
            'instructor_id' => 1, // assuming first instructor exists
            'type' => 'free',
            'duration' => 3,
            'price' => 0.00,
            'difficulty' => 'beginner',
            'status' => 2,
        ]);

        // Generate 10 random courses
        Course::factory()->count(10)->create();
    }
}
