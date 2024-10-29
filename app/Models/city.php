<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class city extends Model
{
    protected $guarded = [];

    public function province()
    {
        return $this->belongsTo(Province::class, 'province_code', 'code');
    }

    public function alamat(){
        return $this->hasMany(alamat::class);
    }
    
}
