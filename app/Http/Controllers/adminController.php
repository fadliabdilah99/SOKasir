<?php

namespace App\Http\Controllers;

use App\Models\margin;
use App\Models\penjualan;
use App\Models\pesanan;
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
            ->whereIn('jenis', ['event', 'ofline'])
            ->groupBy(DB::raw('MONTH(created_at)'))
            ->orderBy(DB::raw('MONTH(created_at)'))
            ->pluck('total', 'month');
        $salesonline = DB::table('penjualans')
            ->select(DB::raw('SUM(total) as total'), DB::raw('MONTH(created_at) as month'))
            ->where('created_at', '>=', $startDate)
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
        $data['pesanan'] = penjualan::whereMonth('created_at', date('m'))->whereYear('created_at', date('Y'))->with('so')->get();
        $data['pemasukanonline'] = $data['pesanan']->where('jenis', 'online')->sum('total');
        $julmahofline = $data['pesanan']->where('jenis', 'ofline')->sum('total') + $data['pesanan']->where('jenis', 'event')->sum('total');
        $data['pemasukanoffline'] = $julmahofline;
        $data['valuasi'] = So::select(DB::raw('sum(hargamodal * qty) as total'))->first()->total;
        $data['totalprod'] = so::sum('qty');
        return view('admin.home.index', compact('offline', 'online', 'bulan'))->with($data);
    }

    public function margin(Request $request, $id){
        $request->validate([
            'margin' => 'required',
        ]);

        margin::where('id', $id)->update(['margin' => $request->margin]);

        return redirect('admin')->with('success', 'Berhasil mengatur margin');
    }
}
