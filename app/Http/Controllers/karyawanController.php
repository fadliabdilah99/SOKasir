<?php

namespace App\Http\Controllers;

use App\Models\kategori;
use Illuminate\Http\Request;

class karyawanController extends Controller
{
    public function index()
    {
        $data['kategori'] = kategori::with( 'so')->get();
        return view('karyawan.page.index')->with($data);
    }
}
