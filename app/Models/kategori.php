<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class kategori extends Model
{
    protected $guarded = [];

    public function so(){
        return $this->hasMany(so::class);
    }
}
