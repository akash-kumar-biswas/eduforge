<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Student;

class StudentSeeder extends Seeder
{
    public function run(): void
    {
        // Create a default student
        Student::create([
            'name' => 'Default Student',
            'email' => 'student@example.com',
            'password' => bcrypt('student123'),
            'status' => 1,
        ]);

        // Generate random students
        Student::factory()->count(10)->create();
    }
}
