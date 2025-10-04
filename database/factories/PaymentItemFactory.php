<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\PaymentItem;
use App\Models\Payment;
use App\Models\Course;

class PaymentItemFactory extends Factory
{
    protected $model = PaymentItem::class;

    public function definition(): array
    {
        return [
            'payment_id' => Payment::factory(),
            'course_id' => Course::factory(),
            'price' => $this->faker->randomFloat(2, 50, 500),
        ];
    }
}
