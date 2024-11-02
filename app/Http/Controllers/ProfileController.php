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
        // Mengambil data penjualan user yang sedang login
        $penjualan = Penjualan::where('user_id', Auth::user()->id)
            ->where('status', 'payment') // filter sesuai status yang diinginkan
            ->with('so') // relasi dengan tabel atau model 'so'
            ->get()
            ->groupBy('kodeInvoice'); // kelompokkan berdasarkan kodeInvoice

        // Map setiap grup kodeInvoice dan masukkan data barang di dalamnya
        $data['dikemast'] = $penjualan->map(function ($items, $kodeInvoice) {
            return [
                'kodeInvoice' => $kodeInvoice,
                'items' => $items // kumpulan barang di setiap kodeInvoice
            ];
        });

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
