<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class prosesco extends Model
{
    protected $guarded = [];

    public function pesanan()
    {
        return $this->belongsTo(pesanan::class);
    }

    public function barangeven()
    {
        return $this->belongsTo(barangeven::class);
    }
    
}
