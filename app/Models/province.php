<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class province extends Model
{
    protected $guarded = [];


    public function cities()
    {
        return $this->hasMany(City::class, 'province_code', 'code');
    }

    public function alamat(){
        return $this->hasMany(alamat::class);
    }
}
