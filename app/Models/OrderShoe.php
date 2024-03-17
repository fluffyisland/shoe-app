<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderShoe extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'shoe_id',
        'shoe_color_id',
        'shoe_size_id',
        'quantity',
        'price',
        'slip_image',
    ];

    public function shoe()
    {
        return $this->belongsTo(Shoe::class);
    }

    public function shoe_color()
    {
        return $this->belongsTo(ShoeColor::class);
    }

    public function shoe_size()
    {
        return $this->belongsTo(ShoeSize::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
