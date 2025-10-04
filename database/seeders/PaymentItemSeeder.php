<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\PaymentItem;

class PaymentItemSeeder extends Seeder
{
    public function run(): void
    {
        PaymentItem::factory()->count(20)->create();
    }
}
