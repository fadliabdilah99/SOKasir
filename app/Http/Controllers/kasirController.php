<?php

namespace App\Http\Controllers;

use App\Models\barangeven;
use App\Models\penjualan;
use App\Models\pesanan;
use App\Models\prosesco;
use App\Models\so;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redis;

class kasirController extends Controller
{
    public function index($id)
    {
        $data['eventId'] = $id;
        $data['pesanan'] = pesanan::where('event_id', $id)->with('prosesco')->get();
        $data['pesanan']->each(function ($pesanan) {
            if (penjualan::where('kodeInvoice', $pesanan->id)->first() == null) {
                $pesanan->delete();
            }
        });
        return view('karyawan.event.kasir')->with($data);
    }

    public function addPesanan(Request $request)
    {
        $pesanan = pesanan::create($request->all());
        return redirect('proses/' . $pesanan->id)->with('success', 'silahkan isi produks');
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

    public function done(Request $request)
    {
        $barangco =  prosesco::where('pesanan_id', $request->pesananId)->get();
        if ($barangco->isEmpty()) {
            return redirect()->back()->with('error', 'tidak ada barang yang di temukan');
        }
        foreach ($barangco as $c) {
            $random = date('d') . time();
            $barangeven = barangeven::where('id', $c->barangeven_id)->with('so')->first();
            $uploadFoto = penjualan::create([
                'so_id' => $barangeven->so->id,
                'kodeInvoice' => $random,
                'user_id' => Auth::user()->id,
                'qty' => $c->qty,
                'total' => $hargajual = $barangeven->so->hargamodal * 0.45 + $barangeven->so->hargamodal * $c->qty,
                'discount' => $hargajual * $barangeven->discount / 100,
                'jenis' => $request->jenis,
            ]);
            prosesco::where('id', $c->id)->delete();
        }

        $uploadFoto = penjualan::where('kodeInvoice', $uploadFoto->kodeInvoice)->first();


        if ($request->bukti != null) {
            $file = $request->file('bukti');
            $ext = $file->getClientOriginalExtension();
            $filename = time() . '.' . $ext;
            $file->move('assets/pembayaran/', $filename);

            $uploadFoto->update([
                'bukti' => $filename
            ]);
        }


        pesanan::where('id', $request->pesananId)->update([
            'id' => $uploadFoto->kodeInvoice,
        ]);
        return redirect('kasir/' . $request->eventId)->with('success', 'Data Berhasil di Hapus, dan mengembalikan ke Stok');
    }


    public function invoice($id)
    {
        $data['id'] = $id;
        $data['invoice'] = penjualan::where('kodeInvoice', $id)->with('so')->get();
        $data['penjualan'] = penjualan::where('kodeInvoice', $id)->first();
        if ($data['penjualan'] == null) {
            return redirect()->back()->with('error', 'tidak ada barang yang di temukan');
        }
        $data['user'] = User::where('id', penjualan::where('kodeInvoice', $id)->first()->user_id)->first();

        return view('karyawan.event.invoice.invoice')->with($data);
    }
    public function print($id)
    {
        $data['id'] = $id;
        $data['invoice'] = penjualan::where('id', $id)->get();
        return view('karyawan.event.invoice.invoiceprint')->with($data);
    }
}
