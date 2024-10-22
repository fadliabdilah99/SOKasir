<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class size extends Model
{
    protected $guarded = [];

    public function shop()
    {
        return $this->belongsTo(shop::class);
    }
}
