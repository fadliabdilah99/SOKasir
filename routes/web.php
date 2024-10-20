<?php

use App\Http\Controllers\adminController;
use App\Http\Controllers\cartController;
use App\Http\Controllers\eventController;
use App\Http\Controllers\karyawanController;
use App\Http\Controllers\kasirController;
use App\Http\Controllers\kategoriController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\shopController;
use App\Http\Controllers\soController;
use App\Http\Controllers\userController;
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
});


Route::get('/', [userController::class, 'index']);

// shop controller
Route::get('info/{id}', [shopController::class, 'info']);



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
    Route::get('invoice/{id}', [kasirController::class, 'invoice']);
    Route::get('print/{id}', [kasirController::class, 'print']);

    // cart manual
    Route::get('cart', [cartController::class, 'index']);
    Route::post('kasir2/{id}', [cartController::class, 'homekasir']);
    Route::post('checkout', [CartController::class, 'checkout']);
    Route::delete('checkout', [CartController::class, 'delete']);

    // shop controller
    Route::get('shop', [shopController::class, 'index']);
    Route::post('shop', [shopController::class, 'add']);
    Route::post('updateshop/{id}', [shopController::class, 'update']);
    Route::delete('deleteShop/{id}', [shopController::class, 'delete']);
});
Route::group(['middleware' => ['role:admin']], function () {
    Route::get('admin', [adminController::class, 'index']);
    Route::post('margin/{id}', [adminController::class, 'margin']);

    Route::post('kembalikan', [eventController::class, 'kembalikan']);


    // event controller
    Route::get('event', [eventController::class, 'index']);
    Route::post('event', [eventController::class, 'create']);
});


require __DIR__ . '/auth.php';
