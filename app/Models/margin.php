<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class margin extends Model
{
    protected $guarded = [];

    public function chart(){

        return $this->hashMany(chart::class);

    }
}
