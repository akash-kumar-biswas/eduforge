<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;

    protected $fillable = [
        'student_id',
        'method',
        'status',
        'total_amount',
        'txnid',
    ];

    protected $casts = [
        'total_amount' => 'decimal:2',
        'status' => 'boolean',
    ];

    public function student()
    {
        return $this->belongsTo(\App\Models\Student::class);
    }

    public function items()
    {
        return $this->hasMany(\App\Models\PaymentItem::class);
    }
}