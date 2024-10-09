<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class pesanan extends Model
{
    protected $guarded = [];

    public function event()
    {
        return $this->belongsTo(event::class);
    }

    public function prosesco()
    {
        return $this->hasMany(prosesco::class);
    }
}
