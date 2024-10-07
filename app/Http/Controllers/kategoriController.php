<?php

namespace App\Http\Controllers;

use App\Models\kategori;
use App\Models\so;
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
        // Validasi input
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'kode' => 'required|string|max:3',
        ]);

        $kategori = Kategori::findOrFail($id);

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
        so::where('kategori_id', $id)->delete();
        kategori::where('id', $id)->delete();
        return redirect('karyawan')->with('success', 'Data kategori dan data terkait berhasil dihapus');
    }
}
