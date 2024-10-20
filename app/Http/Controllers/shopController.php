<?php

namespace App\Http\Controllers;

use App\Models\foto;
use App\Models\margin;
use App\Models\shop;
use App\Models\so;
use Illuminate\Http\Request;

class shopController extends Controller
{
    public function index()
    {
        $data['so'] = so::with('kategori')->get();
        $data['barangs'] = shop::with('so')->with('kategori')->with('foto')->get();
        return view('karyawan.shop.index')->with($data);
    }

    public function add(Request $request)
    {

        $request->validate([
            'qty' => 'required',
            'detail' => 'required',
            'deskripsi' => 'required',
            'foto.*' => 'required|image',
        ]);

        if (shop::where('so_id', $request->so_id)->first() != null) {
            return redirect()->back()->with('error', 'Data tersebut sudah ditambahkan, anda bisa mengubahnya pada table di atas');
        }
        $so = so::where('id', $request->so_id)->first();
        $qtynew = $so->qty - $request->qty;
        $shop = shop::create([
            'so_id' => $request->so_id,
            'kategori_id' => $request->kategori_id,
            'qty' => $request->qty,
            'detail' => $request->detail,
            'discount' => $request->discount,
            'deskripsi' => $request->deskripsi,
        ]);
        so::where('id', $request->so_id)->update(['qty' => $qtynew]);

        if ($request->hasFile('foto')) {
            foreach ($request->file('foto') as $file) {
                $ext = $file->getClientOriginalExtension();
                $filename = rand(1, 900)  . time() . '.' . $ext;
                $file->move('assets/asset/', $filename);

                foto::create([
                    'shop_id' => $shop->id,
                    'fotos' => $filename
                ]);
            }
        }


        return redirect()->back()->with('success', 'Berhasil menambahkan produk market, dan penyimpanan foto');
    }

    public function update(Request $request, $id)
    {
        // Validasi input
        $request->validate([
            'qty' => 'required',
        ]);

        // Ambil data qty dari tabel `shop` dan `so`
        $shop = shop::where('id', $request->so_id)->first();
        $so = so::where('kode', $request->kode)->first();

        // Hitung total stok yang tersedia
        $totalQtyAvailable = $shop->qty + $so->qty;

        // Cek apakah qty yang diinput melebihi stok
        if ($request->qty > $totalQtyAvailable) {
            return redirect()->back()->with('error', 'Jumlah yang diinput melebihi stok');
        }

        // Hitung qty baru untuk tabel `so`
        if ($request->qty > $shop->qty) {
            $newSoQty = $so->qty - ($request->qty - $shop->qty);
        } else {
            $newSoQty = ($shop->qty - $request->qty) + $so->qty;
        }

        $so->update(['qty' => $newSoQty]);
        $shopData = [
            'qty' => $request->qty,
            'discount' => $request->discount,
        ];

        if ($request->filled('detail')) {
            $shopData['detail'] = $request->detail;
        }

        if ($request->filled('deskripsi')) {
            $shopData['deskripsi'] = $request->deskripsi;
        } else {
            $shopData['deskripsi'] = $shop->deskripsi;
        }

        $shop->update($shopData);




        if ($request->hasFile('foto')) {
            foto::where('shop_id', $request->so_id)->get()->each(function ($fotos) use ($request) {
                unlink('assets/asset/' . $fotos->fotos);
                $fotos->delete();
            });
            foreach ($request->file('foto') as $file) {
                $ext = $file->getClientOriginalExtension();
                $filename = rand(1, 900)  . time() . '.' . $ext;
                $file->move('assets/asset/', $filename);

                foto::create([
                    'shop_id' => $request->so_id,
                    'fotos' => $filename
                ]);
            }
        }
        return redirect()->back()->with('success', 'Data Berhasil di Update');
    }

    public function delete($id)
    {
        shop::where('id', $id)->delete();
        $foto = foto::where('shop_id', $id)->get();
        foreach ($foto as $f) {
            unlink('assets/asset/' . $f->fotos);
            $f->delete();
        }
        return redirect()->back()->with('success', 'Data Berhasil di Hapus');
    }



    // user paeg

    public function info($id)
    {
        $data['margins'] = margin::where('jenis', 'online')->first();
        $data['shop'] = shop::where('id', $id)->with('so')->with('foto')->first();
        $data['rekomendasi'] = shop::where('id', '!=', $id)->inRandomOrder()->take(6)->get();
        return view('user.cart.info')->with($data);
    }
}
