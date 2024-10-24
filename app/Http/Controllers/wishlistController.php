<?php

namespace App\Http\Controllers;

use App\Models\margin;
use App\Models\wishlist;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class wishlistController extends Controller
{

    public function index()
    {
        $wishlists = wishlist::where('user_id', Auth::user()->id)->with('shop')->get();
        $margins = margin::where('jenis', 'online')->first();
        return view('shop.wishlist.index', compact('wishlists', 'margins'));
    }
    public function wishlist(Request $request)
    {
        if (wishlist::where('user_id', $request->user_id)->where('shop_id', $request->shop_id)->first() != null) {
            wishlist::where('user_id', $request->user_id)->where('shop_id', $request->shop_id)->delete();
            return redirect()->back();
        } else {
            $request->validate([
                'shop_id' => 'required',
                'user_id' => 'required',
            ]);
            wishlist::create($request->all());
            return redirect()->back();
        }
    }
}
