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
}
