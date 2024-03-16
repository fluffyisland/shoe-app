<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ShoeColor extends Model
{
    use HasFactory;

    protected $fillable = [
        'shoe_id',
        'color',
        'photo_url',
    ];

    public function shoeSizes()
    {
        return $this->hasMany(ShoeSize::class);
    }

    public function shoe()
    {
        return $this->belongsTo(Shoe::class);
    }
}
