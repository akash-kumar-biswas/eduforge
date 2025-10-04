<?php

namespace Database\Factories;

use App\Models\Course;
use App\Models\Instructor;
use Illuminate\Database\Eloquent\Factories\Factory;

class CourseFactory extends Factory
{
    protected $model = Course::class;

    public function definition(): array
    {
        return [
            'title' => $this->faker->sentence(4),
            'description' => $this->faker->paragraph(),
            'instructor_id' => Instructor::inRandomOrder()->first()?->id,
            'type' => $this->faker->randomElement(['free', 'paid']),
            'duration' => $this->faker->optional()->numberBetween(1, 100),
            'price' => $this->faker->randomFloat(2, 0, 100),
            'difficulty' => $this->faker->randomElement(['beginner', 'intermediate', 'advanced']),
            'image' => null,
            'content_url' => null,
            'status' => $this->faker->randomElement([0,1,2]),
        ];
    }
}
