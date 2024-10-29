<?php

namespace App\Http\Controllers;

use App\Models\barangeven;
use App\Models\chart;
use App\Models\foto;
use App\Models\kategori;
use App\Models\shop;
use App\Models\so;
use Illuminate\Http\Request;

class soController extends Controller
{
    public function create(Request $request)
    {
        $request->validate([
            'kode' => 'required|string|max:255',
            'kategori_id' => 'required',
            'foto' => 'required', // file harus berupa gambar
            'nama' => 'required|string|max:255',
            'deskripsi' => 'required|string',
            'hargamodal' => 'required|numeric|min:0', // harga harus angka
            'qty' => 'required|integer|min:1', // qty harus angka integer
            'keterangan' => 'nullable|string|max:500', // optional field
        ]);

        $kategori = kategori::where('id', $request->kategori_id)->first();
        $kode = $kategori->kode . '-' . $request->kode;

        if (so::where('kode', $kode)->exists()) {
            return redirect('karyawan')->with('error', 'Kode SO sudah ada');
        }

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

    public function update(Request $request, $id)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'deskripsi' => 'required|string',
            'hargamodal' => 'required|numeric|min:0',
            'qty' => 'required|integer',
        ]);

        $so = so::where('id', $id)->first();

        $data = [
            'nama' => $request->nama,
            'deskripsi' => $request->deskripsi,
            'hargamodal' => $request->hargamodal,
            'qty' => $request->qty,
        ];

        chart::where('so_id', $id)->delete();

        // pengecekan bila data tertentu di isi atau tidak
        if ($request->hasFile('foto') != null) {
            unlink('assets/fotoSO/' . $so->foto);
            $file = $request->file('foto');
            $ext = $file->getClientOriginalExtension();
            $filename = time() . '.' . $ext;
            $file->move('assets/fotoSO/', $filename);
            $data['foto'] = $filename;
        }
        if ($request->kategori_id != null) {
            $data['kategori_id'] = $request->kategori_id;
        }
        if ($request->keterangan != null) {
            $data['keterangan'] = $request->keterangan;
        }
        if ($request->kode != null) {
            $data['kode'] = kategori::where('id', $so->kategori_id)->first()->kode . '-' . $request->kode;
        }

        so::where('id', $id)->update($data);
        return redirect('karyawan')->with('success', 'Data Berhasil di perbarui');
    }

    public function destroy($id)
    {
        $shop = shop::where('so_id', $id)->get();
        foreach ($shop as $s) {
            $fotos = foto::where('shop_id', $shop->id)->get();
            foreach ($fotos as $foto) {
                // Hapus setiap file foto
                if (file_exists('assets/asset/' . $foto->fotos)) {
                    unlink('assets/asset/' . $foto->fotos);
                }
                // Hapus data foto
                $foto->delete();
            }
            $s->delete();
        }
        barangeven::where('so_id', $id)->delete();
        $so = so::where('id', $id)->first();
        unlink('assets/fotoSO/' . $so->foto);
        so::where('id', $id)->delete();
        return redirect('karyawan')->with('success', 'Data Berhasil di hapus');
    }
}
