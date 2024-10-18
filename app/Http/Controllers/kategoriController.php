<?php

namespace App\Http\Controllers;

use App\Models\barangeven;
use App\Models\foto;
use App\Models\kategori;
use App\Models\shop;
use App\Models\so;
use Illuminate\Http\Request;

class kategoriController extends Controller
{
    public function create(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:kategoris',
            'kode' => 'required',
            'foto' => 'required|image',
        ]);

        $file = $request->file('foto');
        $ext = $file->getClientOriginalExtension();
        $filename = time() . '.' . $ext;
        $file->move('images', $filename);

        kategori::create([
            'name' => $request->name,
            'kode' => $request->kode,
            'foto' => $filename
        ]);
        return redirect('karyawan')->with('success', 'Data kategori berhasil ditambahkan');
    }

    public function update(Request $request, $id)
    {
        // Validasi input
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'kode' => 'required|string|max:3',
        ]);


        $kategori = Kategori::findOrFail($id);
        if ($request->hasFile('foto')) {


            if (file_exists('images/' . $kategori->foto)) {
                unlink('images/' . $kategori->foto);
            }



            $file = $request->file('foto');
            $ext = $file->getClientOriginalExtension();
            $filename = time() . '.' . $ext;
            $file->move('images', $filename);
            $validatedData['foto'] = $filename;
        }

        $soRecords = So::where('kategori_id', $id)->get();

        foreach ($soRecords as $so) {
            $currentKode = $so->kode;

            $parts = explode('-', $currentKode, 2);

            if (count($parts) == 2) {
                $newKode = $validatedData['kode'] . '-' . $parts[1];
                $so->kode = $newKode;
                $so->save();
            }
        }

        // Update kategori
        $kategori->update($validatedData);

        return redirect('karyawan')->with('success', 'Kategori berhasil diperbarui');
    }



    public function destroy($id)
    {
        $kategori = kategori::findOrFail($id);

        if (file_exists('images/' . $kategori->foto)) {
            unlink('images/' . $kategori->foto);
        }

        $soRecords = so::where('kategori_id', $id)->get();
        foreach ($soRecords as $so) {
            unlink('assets/fotoSO/' . $so->foto);
            $shops = shop::where('so_id', $so->id)->get();
            foreach ($shops as $shop) {
                $fotos = foto::where('shop_id', $shop->id)->get();
                foreach ($fotos as $foto) {
                    if (file_exists('assets/asset/' . $foto->fotos)) {
                        unlink('assets/asset/' . $foto->fotos);
                    }
                    $foto->delete();
                }
                $shop->delete();
            }
            barangeven::where('so_id', $so->id)->delete();
        }
        so::where('kategori_id', $id)->delete();

        $kategori->delete();

        return redirect('karyawan')->with('success', 'Data kategori dan data terkait berhasil dihapus');
    }
}
