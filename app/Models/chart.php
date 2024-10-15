<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class chart extends Model
{
    protected $guarded = [];

    public function so()
    {
        return $this->belongsTo(so::class);
    }

    public function margin(){
        return $this->belongsTo(margin::class);
    }
}
