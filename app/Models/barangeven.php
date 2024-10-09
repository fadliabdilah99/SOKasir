<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class barangeven extends Model
{
    protected $guarded = [];

    public function event()
    {
        return $this->belongsTo(event::class);
    }

    public function so()
    {
        return $this->belongsTo(so::class);
    }
}
