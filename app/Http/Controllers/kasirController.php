<?php

namespace App\Http\Controllers;

use App\Models\barangeven;
use App\Models\pesanan;
use App\Models\prosesco;
use App\Models\so;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redis;

class kasirController extends Controller
{
    public function index($id)
    {
        $data['eventId'] = $id;
        $data['pesanan'] = pesanan::where('event_id', $id)->with('prosesco')->get();
        return view('karyawan.event.kasir')->with($data);
    }

    public function addPesanan(Request $request)
    {
        $pesanan = pesanan::create($request->all());
        return redirect('proses/' . $pesanan->id)->with('success', 'silahkan isi produk');
    }


    public function proses($id)
    {
        $data['eventId'] = pesanan::where('id', $id)->first()->event_id;
        $data['pesananId'] = $id;
        $data['barangs'] = barangeven::where('event_id', $data['eventId'])->with('so')->get();
        $data['cart'] = prosesco::where('pesanan_id', $id)->with('barangeven')->get();
        return view('karyawan.event.proses')->with($data);
    }

    public function addprod(Request $request)
    {
        $barangeven = barangeven::where('id', $request->barangeven_id)->first();
        $newqty = $barangeven->qty - $request->qty;
        prosesco::create($request->all());
        $barangeven->update(['qty' => $newqty]);
        return redirect()->back()->with('success', 'Data Berhasil di Tambahkan');
    }

    public function destroyprod($id, Request $request)
    {
        $barangeven = barangeven::where('id', $request->barangeven_id)->first();
        $newqty = $barangeven->qty + $request->qty;
        $barangeven->update(['qty' => $newqty]);
        prosesco::where('id', $id)->delete();
        return redirect()->back()->with('success', 'Data Berhasil di Hapus');
    }

    public function batalkan(Request $request)
    {
        $co = prosesco::where('pesanan_id', $request->pesanan_id)->get();
        foreach ($co as $c) {
            $barangeven = barangeven::where('id', $c->barangeven_id)->first();
            $newqty = $barangeven->qty + $c->qty;
            $barangeven->update(['qty' => $newqty]);
            prosesco::where('id', $c->id)->delete();
        }

        pesanan::where('id', $request->pesanan_id)->delete();

        return redirect('kasir/' . $request->eventId)->with('success', 'Data Berhasil di Hapus, dan mengembalikan ke Stok');
    }


}
