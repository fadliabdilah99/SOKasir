<?php

namespace App\Http\Controllers;

use App\Models\chart;
use App\Models\margin;
use App\Models\penjualan;
use App\Models\so;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class cartController extends Controller
{

    public function index()
    {
        $data['carts'] = chart::where('user_id', Auth::user()->id)->get();
        return view('shop.cart.index')->with($data);
    }


    public function homekasir($id, Request $request)
    {
        $request->validate([
            'qty' => 'required',
            'so_id' => 'required',
            'margin' => 'required',
        ]);
        $margin = margin::where('id', $request->margin)->first();
        $so = so::where('id', $request->so_id)->first();
        $qtynew = $so->qty - $request->qty;
        so::where('id', $request->so_id)->update(['qty' => $qtynew]);
        $hargajual = $request->hargamodal * $margin->margin / 100 + $request->hargamodal;
        chart::create([
            'user_id' => $request->user_id,
            'so_id' => $request->so_id,
            'qty' => $request->qty,
            'total' => $testing = $hargajual * $request->qty,
            'discount' => $testing * $request->discount / 100,
            'margin' => $margin->jenis,
        ]);

        return redirect()->back()->with('success', 'Data Berhasil di Tambahkan');
    }

    public function delete(Request $request)
    {
        // Validasi bahwa setidaknya satu item dipilih
        $request->validate([
            'selected_items' => 'required|array|min:1',
        ]);

        // Ambil semua ID item yang dipilih
        $selectedItems = $request->input('selected_items');

        // Loop melalui setiap ID yang dipilih
        foreach ($selectedItems as $id) {
            $cart = Chart::where('id', $id)->first();
            if ($cart) {
                // Cari barang yang terkait di tabel `so`
                $so = So::where('id', $cart->so_id)->first();
                if ($so) {
                    // Update jumlah stok pada tabel `so`
                    $so->qty += $cart->qty;
                    $so->save();
                }

                // Hapus item dari tabel cart
                $cart->delete();
            }
        }

        // Redirect kembali dengan pesan sukses
        return redirect()->back()->with('success', 'Selected items have been deleted successfully.');
    }
    public function checkout(Request $request)
    {
        $selectedItems = $request->input('selected_items', []);

        $kode = date('d') . time();

        if (count($selectedItems) > 0) {
            $carts = chart::whereIn('id', $selectedItems)->first();

            penjualan::create([
                'so_id' => $carts->so_id,
                'kodeInvoice' => $kode,
                'user_id' => Auth::user()->id,
                'qty' => $carts->qty,
                'total' => $carts->total - $carts->discount,
                'discount' => $carts->discount,
                'jenis' => $carts->margin,
            ]);

            $carts->delete();


            return redirect('karyawan')->with('success', 'Checkout berhasil!');
        }

        return redirect()->back()->with('error', 'Pilih item untuk checkout.');
    }
}
