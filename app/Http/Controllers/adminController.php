<?php

namespace App\Http\Controllers;

use App\Models\barangeven;
use App\Models\margin;
use App\Models\penjualan;
use App\Models\pesanan;
use App\Models\shop;
use App\Models\so;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class adminController extends Controller
{
    public function index()
    {
        // Mendapatkan tanggal 6 bulan terakhir
        $startDate = Carbon::now()->subMonths(6);

        // Mengambil total penjualan per bulan selama 6 bulan terakhir berdasarkan created_at
        $salesData = DB::table('penjualans')
            ->select(DB::raw('SUM(total) as total'), DB::raw('MONTH(created_at) as month'))
            ->where('created_at', '>=', $startDate)
            ->where('status', 'success')
            ->whereIn('jenis', ['event', 'ofline'])
            ->groupBy(DB::raw('MONTH(created_at)'))
            ->orderBy(DB::raw('MONTH(created_at)'))
            ->pluck('total', 'month');
        $salesonline = DB::table('penjualans')
            ->select(DB::raw('SUM(total) as total'), DB::raw('MONTH(created_at) as month'))
            ->where('created_at', '>=', $startDate)
            ->where('status', 'success')
            ->whereIn('jenis', ['online'])
            ->groupBy(DB::raw('MONTH(created_at)'))
            ->orderBy(DB::raw('MONTH(created_at)'))
            ->pluck('total', 'month');

        // Membuat array dengan 6 bulan terakhir dan nilai default 0 jika tidak ada penjualan
        $offline = [];
        $online = [];
        $bulan = [];
        for ($i = 0; $i < 6; $i++) {
            // Mengambil bulan dalam angka (1-12)
            $month = Carbon::now()->subMonths(5 - $i)->format('n');
            // Mengambil nama bulan
            $bulan[] = Carbon::now()->subMonths(5 - $i)->format('F');
            // Set nilai penjualan, jika tidak ada data penjualan set default 0
            $offline[] = $salesData->get($month, 0);
            $online[] = $salesonline->get($month, 0);
        }
        $data['margin'] = margin::get();
        $data['pesanan'] = penjualan::whereMonth('created_at', date('m'))->whereYear('created_at', date('Y'))->where('status', 'success')->with('so')->get();
        $data['pemasukanonline'] = $data['pesanan']->where('jenis', 'online')->sum('total');
        $julmahofline = $data['pesanan']->where('jenis', 'ofline')->sum('total') + $data['pesanan']->where('jenis', 'event')->sum('total');
        $data['pemasukanoffline'] = $julmahofline;


        $data['valuasi'] = So::select(DB::raw('sum(hargamodal * qty) as total_so'))
            ->first()
            ->total_so;

        // Valuasi dari tabel `shops`
        $data['valuasi_shop'] = Shop::join('sos', 'shops.so_id', '=', 'sos.id')
            ->select(DB::raw('sum((sos.hargamodal * shops.qty) * (1 - (shops.discount / 100))) as total_shop'))
            ->first()
            ->total_shop;

        // Valuasi dari tabel `barangevens`
        $data['valuasi_event'] = barangeven::join('sos', 'barangevens.so_id', '=', 'sos.id')
            ->select(DB::raw('sum((sos.hargamodal * barangevens.qty) * (1 - (barangevens.discount / 100))) as total_event'))
            ->first()
            ->total_event;

        // Total valuasi dari ketiga tabel
        $data['valuasi'] = $data['valuasi'] + $data['valuasi_shop'] + $data['valuasi_event'];
        $data['totalprod'] = so::sum('qty') + barangeven::sum('qty') + shop::sum('qty');
        return view('admin.home.index', compact('offline', 'online', 'bulan'))->with($data);
    }

    public function margin(Request $request, $id)
    {
        $request->validate([
            'margin' => 'required',
        ]);

        margin::where('id', $id)->update(['margin' => $request->margin]);

        return redirect('admin')->with('success', 'Berhasil mengatur margin');
    }
}
