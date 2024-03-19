<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'total_amount',
        'slip_image',
    ];

    public function order_shoes()
    {
        return $this->hasMany(OrderShoe::class);
    }
}
