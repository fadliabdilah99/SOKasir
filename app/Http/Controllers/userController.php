<?php

namespace App\Http\Controllers;

use App\Models\kategori;
use App\Models\margin;
use Illuminate\Http\Request;

class userController extends Controller
{
    public function index()
    {
        $data['kategoris'] = kategori::with('shop')->get();
        $data['margins'] = margin::where('jenis', 'online')->first();
        return view('user.home.index')->with($data);
    }
}
