<?php

namespace App\Http\Controllers;

use App\Models\kategori;
use Illuminate\Http\Request;

class kategoriController extends Controller
{
    public function create(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:kategoris',
            'kode' => 'required'
        ]);
        kategori::create($request->all());
        return redirect('karyawan')->with('success', 'Data kategori berhasil ditambahkan');
    }

    public function update(Request $request, $id)
    {
        $kategori = Kategori::findOrFail($id);
        $kategori->update($request->all());

        return redirect()->back()->with('success', 'Kategori berhasil diupdate');
    }

    public function destroy($id)
    {
        kategori::destroy($id);
        return redirect('karyawan')->with('success', 'Data Kategori Berhasilahsil Dihapus');
    }
}
