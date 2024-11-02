<?php

namespace App\Http\Controllers;

use App\Models\alamat;
use App\Models\penjualan;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class pesananController extends Controller
{
    public function dikemas()
    {
        $penjualan = penjualan::where('status', 'payment')
            ->with('so')
            ->get()
            ->groupBy('kodeInvoice');


        $data['dikemast'] = $penjualan->map(function ($items, $kodeInvoice) {
            return [
                'kodeInvoice' => $kodeInvoice,
                'items' => $items
            ];
        });

        return view('karyawan.shop.dikemas')->with($data);
    }

    public function dikirim(Request $request, $id)
    {
        penjualan::where('kodeInvoice', $id)->update([
            'status' => 'sending',
            'resi' => $request->resi,
        ]);

        return redirect('shop')->with('success', 'Pesanan dikirim');
    }

    public function print($id)
    {
        $data['penjualan'] = penjualan::where('kodeInvoice', $id)->first();
        $data['user'] = User::where('id', $data['penjualan']->user_id)->first();
        $data['alamat'] = alamat::where('user_id', $data['user']->id)->where('status', 'primary')->with('city')->with('province')->first();
        $data['berat'] = penjualan::where('kodeInvoice', $id)->sum('qty') * 250;
        return view('karyawan.shop.print')->with($data);
    }
}
