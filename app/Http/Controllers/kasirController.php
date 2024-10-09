<?php

namespace App\Http\Controllers;

use App\Models\barangeven;
use App\Models\pesanan;
use App\Models\prosesco;
use App\Models\so;
use Illuminate\Http\Request;

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
        pesanan::create($request->all());
        return redirect('proses/' . $request->event_id)->with('success', 'silahkan isi produk');
    }


    public function proses($id)
    {
        $data['pesananId'] = $id;
        $data['barangs'] = barangeven::where('event_id', $id)->with('so')->get();
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

    public function destroy($id, Request $request){
         $barangeven = barangeven::where('id', $request->barangeven_id)->first();
         $newqty = $barangeven->qty + $request->qty;
         $barangeven->update(['qty' => $newqty]);
         prosesco::where('id', $id)->delete();
         return redirect()->back()->with('success', 'Data Berhasil di Hapus');
    }

}
