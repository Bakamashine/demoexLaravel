<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
        'user_id',
        'course_name',
        'date',
        'payment_type',
        'status',
    ];

    protected $casts = [
        'date' => 'date',
        'status' => \App\Enum\OrderStatus::class,
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
