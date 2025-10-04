<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Enrollment;

class EnrollmentSeeder extends Seeder
{
    public function run(): void
    {
        // Generate 20 random enrollments
        Enrollment::factory()->count(20)->create();
    }
}
