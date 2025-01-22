<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use App\Models\penjualan;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class ProfileController extends Controller
{



    public function profile()
    {
        $penjualan = Penjualan::where('user_id', Auth::user()->id)
            ->where('status', 'payment')
            ->with('so')
            ->get()
            ->groupBy('kodeInvoice');
        $data['dikemast'] = $penjualan->map(function ($items, $kodeInvoice) {
            return [
                'kodeInvoice' => $kodeInvoice,
                'items' => $items
            ];
        });


        $dikirim = Penjualan::where('user_id', Auth::user()->id)
            ->where('status', 'sending')
            ->with('so')
            ->get()
            ->groupBy('kodeInvoice');
        $data['sendings'] = $dikirim->map(function ($items, $kodeInvoice) {
            return [
                'kodeInvoice' => $kodeInvoice,
                'items' => $items
            ];
        });


        $selesai = Penjualan::where('user_id', Auth::user()->id)
            ->where('status', 'success')
            ->with('so')
            ->get()
            ->groupBy('kodeInvoice');
        $data['successt'] = $selesai->map(function ($items, $kodeInvoice) {
            return [
                'kodeInvoice' => $kodeInvoice,
                'items' => $items
            ];
        });

        $data['pembelian'] = $selesai->count();
        $data['alamat'] = Auth::user()->alamat->where('status', 'primary')->first();

        return view('user.profile.index')->with($data);
    }




    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        return view('profile.edit', [
            'user' => $request->user(),
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $request->user()->fill($request->validated());

        if ($request->user()->isDirty('email')) {
            $request->user()->email_verified_at = null;
        }

        $request->user()->save();

        return Redirect::route('profile.edit')->with('status', 'profile-updated');
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}
