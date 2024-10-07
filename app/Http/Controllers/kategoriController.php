<?php

namespace App\Http\Controllers;

use App\Models\kategori;
use App\Models\so;
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

    public function destroy($id){
        so::where('kategori_id', $id)->delete();
        kategori::where('id', $id)->delete();
        return redirect('karyawan')->with('success', 'Data kategori dan data terkait berhasil dihapus');
    }
}
