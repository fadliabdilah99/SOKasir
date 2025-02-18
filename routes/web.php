<?php

use App\Http\Controllers\adminController;
use App\Http\Controllers\alamatController;
use App\Http\Controllers\cartController;
use App\Http\Controllers\eventController;
use App\Http\Controllers\karyawanController;
use App\Http\Controllers\kasirController;
use App\Http\Controllers\kategoriController;
use App\Http\Controllers\ongkirController;
use App\Http\Controllers\paymentController;
use App\Http\Controllers\pesananController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\shopController;
use App\Http\Controllers\soController;
use App\Http\Controllers\userController;
use App\Http\Controllers\wishlist;
use App\Http\Controllers\wishlistController;
use App\Http\Controllers\wishlists;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;



Route::get('/dashboard', function () {
    if (Auth::user()->role == 'karyawan') {
        return redirect('karyawan');
    } elseif (Auth::user()->role == 'admin') {
        return redirect('admin');
    } elseif (Auth::user()->role == 'user') {
        return redirect('user');
    }
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('profiles', [ProfileController::class, 'profile']);


    // cek ongkir
    Route::get('/shipping', [ongkirController::class, 'index']);
    Route::post('/check-ongkir', [ongkirController::class, 'checkOngkir']);
    Route::get('payment', [ongkirController::class, 'getOngkir']);

    // alamat controller
    Route::get('alamat', [alamatController::class, 'alamat']);
    Route::get('alamat/cities', [alamatController::class, 'getCities']);
    Route::post('address', [alamatController::class, 'create']);
    Route::get('alamatUtama/{id}', [alamatController::class, 'alamatutama']);


    // shop controller
    Route::get('info/{id}', [shopController::class, 'info']);

    // cart controller
    Route::post('addcart', [CartController::class, 'addcart']);
    Route::get('carts', [CartController::class, 'checkcart']);
    Route::delete('cartcancle/{id}', [CartController::class, 'cartcancle']);

    // wishlist controller
    Route::get('wishlist', [wishlistController::class, 'index']);
    Route::post('addwishlist', [wishlistController::class, 'wishlist']);


    // invoice
    Route::get('invoice/{id}', [kasirController::class, 'invoice']);
    Route::get('print/{id}', [kasirController::class, 'print']);
});


Route::get('/', [userController::class, 'index']);

Route::group(['middleware' => ['role:karyawan']], function () {
    Route::get('karyawan', [karyawanController::class, 'index']);

    // kategori controller
    Route::post('kategori', [kategoriController::class, 'create']);
    Route::delete('kategori/{id}', [kategoriController::class, 'destroy']);
    Route::post('updatekat/{id}', [kategoriController::class, 'update']);

    // so controller
    Route::post('so', [soController::class, 'create']);
    Route::delete('so/{id}', [soController::class, 'destroy']);
    Route::post('updateSO/{id}', [soController::class, 'update']);

    // evebt controller
    Route::get('event-karyawan', [eventController::class, 'karyawan']);
    Route::get('infoProd/{id}', [eventController::class, 'infoProd']);
    Route::post('addEventProd', [eventController::class, 'addEventProd']);
    Route::delete('deleteProd/{id}', [eventController::class, 'destroyprod']);
    Route::post('infoProd/update/{id}', [eventController::class, 'updateinfo']);


    // kasir controller
    Route::get('kasir/{id}', [kasirController::class, 'index']);
    Route::post('addPesanan', [kasirController::class, 'addPesanan']);
    Route::get('proses/{id}', [kasirController::class, 'proses']);
    Route::post('batalkan', [kasirController::class, 'batalkan']);
    Route::post('addprod', [kasirController::class, 'addprod']);
    Route::delete('deleteProds/{id}', [kasirController::class, 'destroyprod']);
    Route::post('selesaikan', [kasirController::class, 'done']);

    // cart manual
    Route::get('cart', [cartController::class, 'index']);
    Route::post('kasir2/{id}', [cartController::class, 'homekasir']);
    Route::post('checkout', [CartController::class, 'checkout']);
    Route::delete('checkout', [CartController::class, 'delete']);

    // shop controller
    Route::get('shop', [shopController::class, 'index']);
    Route::post('shop', [shopController::class, 'add']);
    Route::post('addsize', [shopController::class, 'size']);
    Route::delete('deletesize/{id}', [shopController::class, 'deletesize']);
    Route::post('updateshop/{id}', [shopController::class, 'update']);
    Route::delete('deleteShop/{id}', [shopController::class, 'delete']);

    // pesanan controller
    Route::get('dikemas', [pesananController::class, 'dikemas']);
    Route::get('dikirim', [pesananController::class, 'dikirim']);
    Route::get('selesai', [pesananController::class, 'selesai']);
    Route::get('print-paket/{id}', [pesananController::class, 'print']);
    Route::post('dikirim/{id}', [pesananController::class, 'sending']);
    Route::get('selesai/{id}', [pesananController::class, 'done']);
});
Route::group(['middleware' => ['role:admin']], function () {
    Route::get('admin', [adminController::class, 'index']);
    Route::post('margin/{id}', [adminController::class, 'margin']);

    Route::post('kembalikan', [eventController::class, 'kembalikan']);


    // event controller
    Route::get('event', [eventController::class, 'index']);
    Route::post('event', [eventController::class, 'create']);
});

Route::post('/donation', [paymentController::class, 'store']);
Route::post('/notification', [paymentController::class, 'notification']);
require __DIR__ . '/auth.php';
