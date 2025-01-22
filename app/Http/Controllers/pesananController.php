<?php

namespace App\Http\Controllers;

use App\Models\alamat;
use App\Models\penjualan;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Twilio\Rest\Client;

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
    public function dikirim()
    {
        $penjualan = penjualan::where('status', 'sending')
            ->with('so')
            ->with('user')
            ->get()
            ->groupBy('kodeInvoice');


        $data['dikemast'] = $penjualan->map(function ($items, $kodeInvoice) {
            return [
                'kodeInvoice' => $kodeInvoice,
                'items' => $items
            ];
        });
        return view('karyawan.shop.dikirim')->with($data);
    }
    public function selesai()
    {
        $penjualan = penjualan::where('status', 'success')
            ->with('so')
            ->get()
            ->groupBy('kodeInvoice');


        $data['selesai'] = $penjualan->map(function ($items, $kodeInvoice) {
            return [
                'kodeInvoice' => $kodeInvoice,
                'items' => $items
            ];
        });

        return view('karyawan.shop.selesai')->with($data);
    }

    public function sending(Request $request, $id)
    {
        penjualan::where('kodeInvoice', $id)->update([
            'status' => 'sending',
            'resi' => $request->resi,
        ]);

        // notifikasi ke user
        $sid    = env('TWILIO_SID');
        $token  = env('TWILIO_TOKEN');
        $twilio = new Client($sid, $token);

        $message = $twilio->messages
            ->create(
                "whatsapp:+6281220786387", // to
                array(
                    "from" => "whatsapp:+14155238886",
                    "body" => 'Hi, ada pesanan yang sedang dikirim, tunggu pesanan mu ya, jangan lupa video sebelum unboxing untuk klain garansi!',
                )
            );

        return redirect('shop')->with('success', 'Pesanan dikirim');
    }
    public function done($id)
    {
        penjualan::where('kodeInvoice', $id)->update([
            'status' => 'success',
        ]);

        return redirect('shop')->with('success', 'Pesanan selesai');
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
