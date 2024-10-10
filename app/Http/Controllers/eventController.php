<?php

namespace App\Http\Controllers;

use App\Models\barangeven;
use App\Models\event;
use App\Models\prosesco;
use App\Models\so;
use Illuminate\Http\Request;

class eventController extends Controller
{
    public function index()
    {
        $data['events'] = event::get();
        return view('admin.event.index')->with($data);
    }

    public function create(Request $request)
    {
        $request->validate([
            'nama' => 'required',
            'lamaevent' => 'required',
            'sampai' => 'required',
            'lokasi'
        ]);

        event::create($request->all());
        return redirect('event')->with('success', 'Data event berhasil ditambahkan');
    }

    public function karyawan()
    {
        $data['events'] = event::where('sampai', '>=', date('Y-m-d'))->with('barangeven')->get();
        return view('karyawan.event.index')->with($data);
    }

    public function infoProd($id)
    {
        $data['so'] = so::with('kategori')->get();
        $data['eventId'] = $id;
        $data['barangs'] = barangeven::where('event_id', $id)->with('so')->get();
        return view('karyawan.event.infoProd')->with($data);
    }

    public function addEventProd(Request $request)
    {
        if (barangeven::where('id', $request->event_id)->where('so_id', $request->so_id)->first() != null) {
            return redirect('infoProd/' . $request->event_id)->with('error', 'Data tersebut sudah ditambahkan, anda bisa mengubahnya pada table di atas');
        }
        $so = so::where('id', $request->so_id)->first();
        $request->validate([
            'qty' => 'required',
        ]);
        $qtynew = $so->qty - $request->qty;
        barangeven::create($request->all());
        so::where('id', $request->so_id)->update(['qty' => $qtynew]);

        return redirect('infoProd/' . $request->event_id)->with('success', 'Data Berhasil di Tambahkan');
    }

    public function addprod(Request $request)
    {
        $barangeven = barangeven::where('id', $request->barangeven_id)->first();
        $newqty = $barangeven->qty - $request->qty;
        prosesco::create($request->all());
        $barangeven->update(['qty' => $newqty]);
        return redirect()->back()->with('success', 'Data Berhasil di Tambahkan');
    }
    public function updateinfo(Request $request)
    {
        // Validasi input
        $request->validate([
            'qty' => 'required',
        ]);
    
        // Ambil data qty dari tabel `barangeven` dan `so`
        $barangeven = barangeven::where('id', $request->event_id)->first();
        $so = so::where('kode', $request->so_id)->first();
    
        // Hitung total stok yang tersedia
        $totalQtyAvailable = $barangeven->qty + $so->qty;
    
        // Cek apakah qty yang diinput melebihi stok
        if ($request->qty > $totalQtyAvailable) {
            return redirect()->back()->with('error', 'Jumlah yang diinput melebihi stok');
        }
    
        // Hitung qty baru untuk tabel `so`
        if ($request->qty > $barangeven->qty) {
            $newSoQty = $so->qty - ($request->qty - $barangeven->qty);
        } else {
            $newSoQty = ($barangeven->qty - $request->qty) + $so->qty;
        }
    
        // Update qty di tabel `so`
        $so->update(['qty' => $newSoQty]);
        // Update qty dan discount di tabel `barangeven`
        $barangeven->update([
            'qty' => $request->qty,
            'discount' => $request->discount,
        ]);
        return redirect()->back()->with('success', 'Data Berhasil di Update');
    }
    
}
