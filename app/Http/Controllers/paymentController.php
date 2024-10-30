<?php

namespace App\Http\Controllers;

use App\Models\chart;
use App\Models\penjualan;
use App\Models\shop;
use App\Models\so;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class paymentController extends Controller
{
    protected $response = [];

    public function __construct()
    {
        \Midtrans\Config::$serverKey = config('services.midtrans.serverKey');
        \Midtrans\Config::$isProduction = config('services.midtrans.isProduction');
        \Midtrans\Config::$isSanitized = config('services.midtrans.isSanitized');
        \Midtrans\Config::$is3ds = config('services.midtrans.is3ds');
    }



    public function store(Request $request)
    {
        $cart = chart::where('user_id', Auth::user()->id)->get();
        $kodeInvoice =  rand(10000, 99999) . time();

        foreach ($cart as $selected) {
            $shops = shop::where('so_id', $selected->so_id)->first();
            if ($shops->qty < $selected->qty) {
                return redirect()->back()->with('error', 'Jumlah yang diinput melebihi stok');
            }
        }



        DB::transaction(function () use ($cart, $kodeInvoice, $request) {
            foreach ($cart as $item) {
                $donation = penjualan::create([
                    'so_id' => $item->so_id,
                    'kodeInvoice' => $kodeInvoice,
                    'user_id' => Auth::user()->id,
                    'qty' => $item->qty,
                    'total' => $item->total,
                    'discount' => $item->discount,
                    'jenis' => $item->margin,
                    'status' => 'pending',
                ]);
            }
            $payload = [
                'transaction_details' => [
                    'order_id'      => $donation->kodeInvoice,
                    'gross_amount'  => $request->pembayaran,
                ],
                'customer_details' => [
                    'first_name'    => Auth::user()->name,
                    'email'         => Auth::user()->email,
                    // 'phone'         => '08888888888',
                    // 'address'       => '',
                ],
                'item_details' => [
                    [
                        'id'       => $donation->jenis,
                        'price'    => $request->pembayaran,
                        'quantity' => 1,
                        'name'     => ucwords(str_replace('_', ' ', $donation->jenis))
                    ]
                ]
            ];

            $snapToken = \Midtrans\Snap::getSnapToken($payload);

            $this->response['snap_token'] = $snapToken;
        });

        return response()->json($this->response);
    }

    public function notification(Request $request)
    {
        // Menerima payload notifikasi dari Midtrans
        $payload = $request->getContent();

        // Log payload notifikasi
        Log::info('Midtrans Notification Received:');
        Log::info($payload);

        // Parsing payload JSON
        $notification = json_decode($payload);

        // Mendapatkan data yang relevan dari notifikasi
        $transactionStatus = $notification->transaction_status;
        $paymentType = $notification->payment_type;
        $kodeInvoice = $notification->order_id;
        $fraudStatus = $notification->fraud_status;

        // Temukan donasi berdasarkan ID pesanan
        $barang = penjualan::where('kodeInvoice', $kodeInvoice)->get();



        // Jika donasi tidak ditemukan, log pesan dan kembalikan respons
        if (!$barang) {
            LOG::error('Donation with order ID ' . $barang->id . ' not found.');
            return response('Donation not found.', 404);
        }

        $barang = penjualan::where('kodeInvoice', $kodeInvoice)->get();

        // Jika barang tidak ditemukan, log pesan dan kembalikan respons
        if ($barang->isEmpty()) {
            Log::error('Donation with order ID ' . $kodeInvoice . ' not found.');
            return response('Donation not found.', 404);
        }

        $status = '';
        
        foreach ($barang as $paymentrespons) {
            if ($transactionStatus == 'capture') {
                if ($paymentType == 'credit_card') {
                    $status = ($fraudStatus == 'challenge') ? 'pending' : 'success';
                    $paymentrespons->status = ($fraudStatus == 'challenge') ? 'pending' : 'success';
                }
            } elseif ($transactionStatus == 'settlement') {
                $status = 'success';
                $paymentrespons->status = 'success';
            } elseif ($transactionStatus == 'pending') {
                $paymentrespons->status = 'pending';
            } elseif ($transactionStatus == 'deny') {
                $paymentrespons->status = 'failed';
            } elseif ($transactionStatus == 'expire') {
                $paymentrespons->status = 'expired';
            } elseif ($transactionStatus == 'cancel') {
                $paymentrespons->status = 'failed';
            }
        
            // Simpan perubahan pada setiap paymentrespons
            $paymentrespons->save();
        }

        if ($status == 'success') {
           $cart =  chart::where('user_id', Auth::user())->get();
           foreach ($cart as $item) {
            $updateqty = shop::where('so_id', $item->so_id)->first();
            $updateqty->update(['qty' => $updateqty->qty - $item->qty]);
            $item->delete();
           }
        }

        // Kembalikan respons OK jika proses berhasil
        return response('Notification processed.', 200);
    }
}
