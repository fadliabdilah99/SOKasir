<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class so extends Model
{
    protected $guarded = [];

    public function kategori()
    {
        return $this->belongsTo(kategori::class);
    }

    public function barangeven()
    {
        return $this->hasMany(barangeven::class);
    }

    public function penjualan()
    {
        return $this->hasMany(penjualan::class);
    }

    public function chart()
    {
        return $this->hasMany(chart::class);
    }

    public function shop(){
        return $this->belongsTo(shop::class);
    }

}
