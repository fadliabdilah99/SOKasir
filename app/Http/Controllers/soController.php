<?php

namespace App\Http\Controllers;

use App\Models\kategori;
use App\Models\so;
use Illuminate\Http\Request;

class soController extends Controller
{
    public function create(Request $request)
    {
        $request->validate([
            'kode' => 'required|string|max:255',
            'kategori_id' => 'required',
            'foto' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048', // file harus berupa gambar
            'nama' => 'required|string|max:255',
            'deskripsi' => 'required|string',
            'hargamodal' => 'required|numeric|min:0', // harga harus angka
            'qty' => 'required|integer|min:1', // qty harus angka integer
            'keterangan' => 'nullable|string|max:500', // optional field
        ]);

        $kategori = kategori::where('id', $request->kategori_id)->first();

        $kode = $kategori->kode . $request->kode;
        $file = $request->file('foto');
        $ext = $file->getClientOriginalExtension();
        $filename = time() . '.' . $ext;
        $file->move('assets/fotoSO/', $filename);

        $data = [
            'kode' => $kode,
            'kategori_id' => $request->kategori_id,
            'foto' => $filename,
            'nama' => $request->nama,
            'deskripsi' => $request->deskripsi,
            'hargamodal' => $request->hargamodal,
            'qty' => $request->qty,
            'keterangan' => $request->keterangan,
        ];
        so::create($data);
        return redirect('karyawan')->with('success', 'Data Berhasilih');
    }
}
