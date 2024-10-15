<?php

namespace App\Http\Controllers;

use App\Models\kategori;
use App\Models\margin;
use App\Models\so;
use Illuminate\Http\Request;

class karyawanController extends Controller
{
    public function index()
    {
        $data['margins'] =  margin::get();
        $data['so'] = so::with('kategori')->get();
        $data['kategori'] = kategori::with( 'so')->get();
        return view('karyawan.page.index')->with($data);
    }
}
