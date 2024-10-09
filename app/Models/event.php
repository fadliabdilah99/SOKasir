<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class event extends Model
{
    protected $guarded = [];

    public function barangeven(){
        return $this->hasMany(barangeven::class);
    }

    public function pesanan(){
        return $this->hasMany(pesanan::class);
    }
}
