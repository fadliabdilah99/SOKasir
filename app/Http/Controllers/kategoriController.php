<?php

namespace App\Http\Controllers;

use App\Models\kategori;
use Illuminate\Http\Request;

class kategoriController extends Controller
{
    public function create(Request $request){
        $request->validate([
            'name' => 'required|unique:kategoris',
            'kode' => 'required'
        ]);
        kategori::create($request->all());
        return redirect('karyawan')->with('success', 'Data kategori berhasil ditambahkan');
    }
}
