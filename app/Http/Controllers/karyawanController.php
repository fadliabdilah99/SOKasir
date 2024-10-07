<?php

namespace App\Http\Controllers;

use App\Models\kategori;
use App\Models\so;
use Illuminate\Http\Request;

class karyawanController extends Controller
{
    public function index()
    {
        $data['so'] = so::with('kategori')->get();
        $data['kategori'] = kategori::with( 'so')->get();
        return view('karyawan.page.index')->with($data);
    }
}
