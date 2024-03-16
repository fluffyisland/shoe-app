<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ShoeSize extends Model
{
    use HasFactory;

    protected $fillable = [
        'shoe_id',
        'shoe_color_id',
        'size',
        'stock',
    ];

    public function shoe()
    {
        return $this->belongsTo(Shoe::class);
    }
    public function shoeColor()
    {
        return $this->belongsTo(ShoeColor::class);
    }
}
