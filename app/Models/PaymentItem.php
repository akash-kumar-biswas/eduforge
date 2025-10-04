<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PaymentItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'payment_id',
        'course_id',
        'price',
    ];

    protected $casts = [
        'price' => 'decimal:2',
    ];

    public function payment()
    {
        return $this->belongsTo(\App\Models\Payment::class);
    }

    public function course()
    {
        return $this->belongsTo(\App\Models\Course::class);
    }
}