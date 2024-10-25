<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class alamatController extends Controller
{
    public function alamat()
    {
        return view('user.alamat.index');
    }
}
