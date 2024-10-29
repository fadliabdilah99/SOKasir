<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class alamat extends Model
{
    protected $guarded = [];

    public function city(){
        return $this->belongsTo(city::class);
    }

    public function province(){
        return $this->belongsTo(province::class);
    }

    public function user(){
        return $this->belongsTo(User::class);
    }
}
