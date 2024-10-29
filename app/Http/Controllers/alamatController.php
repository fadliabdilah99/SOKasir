<?php

namespace App\Http\Controllers;

use App\Models\alamat;
use App\Models\city;
use App\Models\province;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class alamatController extends Controller
{
    public function alamat()
    {
        $data['provinsi'] = Province::all();
        $data['kota'] = City::all();
        $data['alamats'] = alamat::where('user_id', Auth::user()->id)->with('city')->with('province')->get();
        return view('user.alamat.index')->with($data);
    }

    public function getCities(Request $request)
    {
        $provinceCode = $request->get('province_code');
        $cities = City::where('province_code', $provinceCode)->get();
        return response()->json($cities);
    }

    public function create(Request $request){
        $request->validate([
            'nama' => 'required|string|max:255',
            'notlpn' => 'required|string|max:15',
            'province_id' => 'required',
            'city_id' => 'required|exists:cities,code',
            'kodePos' => 'required|numeric|digits:5',
            'alamatlengkap' => 'required|string|max:500',
            'patokan' => 'nullable|string|max:255',
            'jenis' => 'required|in:rumah,kantor',
        ]);

        if(alamat::where('user_id', Auth::user()->id)->first() == null){
            $request['status'] = 'primary';
        }else{
            $request['status'] = 'secondary';
        }

        alamat::create($request->all());

        return redirect()->back()->with('success', 'Berhasil menambahkan alamat');
    }

    public function alamatutama($id){
        alamat::where('user_id', Auth::user()->id)->where('status', 'primary')->update(['status' => 'secondary']);
        alamat::where('id', $id)->update(['status' => 'primary']);
        return redirect()->back()->with('success', 'Berhasil mengubah alamat utama');
    }
}
