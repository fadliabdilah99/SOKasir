<?php

namespace App\Http\Controllers;

use App\Models\so;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class adminController extends Controller
{
    public function index()
    {
        $data['valuasi'] = So::select(DB::raw('sum(hargamodal * qty) as total'))->first()->total;
        $data['totalprod'] = so::sum('qty');
        return view('admin.home.index')->with($data);
    }
}
