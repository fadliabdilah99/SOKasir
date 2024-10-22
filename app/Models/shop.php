<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class shop extends Model
{
    protected $guarded = [];

    public function foto(){
        return $this->hasMany(foto::class);

    }

    public function so(){
        return $this->belongsTo(so::class);
    }

    public function kategori(){
        return $this->belongsTo(kategori::class);
    }

    public function size(){
        return $this->hasMany(size::class);
    }
}
