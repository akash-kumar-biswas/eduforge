<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Instructor;

class InstructorSeeder extends Seeder
{
    public function run(): void
    {
        // Default instructor
        Instructor::create([
            'name' => 'Default Instructor',
            'email' => 'instructor@example.com',
            'password' => bcrypt('instructor123'),
            'status' => rand(0, 1),
        ]);

        // Generate 10 random instructors
        Instructor::factory()->count(10)->create();
    }
}
