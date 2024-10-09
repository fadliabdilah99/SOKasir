<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class penjualan extends Model
{
    protected $guarded = [];

    public function so(){
        return $this->belongsTo(so::class);
    }
}
