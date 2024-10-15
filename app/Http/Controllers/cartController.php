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
        $id = $request->id;
        $cart = chart::where('id', $id)->first();
        $so = so::where('id', $cart->so_id)->first();
        $qtynew = $so->qty + $cart->qty;
        so::where('id', $cart->so_id)->update(['qty' => $qtynew]);
        $cart->delete();
        return redirect()->back()->with('success', 'Data Berhasil di Hapus');
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
                'total' => $carts->total,
                'discount' => $carts->discount,
                'jenis' => $carts->margin,
            ]);

            $carts->delete();


            return redirect('karyawan')->with('success', 'Checkout berhasil!');
        }

        return redirect()->back()->with('error', 'Pilih item untuk checkout.');
    }
}
