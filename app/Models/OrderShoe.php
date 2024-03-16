<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderShoe extends Model
{
    use HasFactory;

    public function shoe()
    {
        return $this->belongsTo(Shoe::class);
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
