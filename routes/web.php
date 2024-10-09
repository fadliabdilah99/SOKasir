<?php

use App\Http\Controllers\adminController;
use App\Http\Controllers\eventController;
use App\Http\Controllers\karyawanController;
use App\Http\Controllers\kategoriController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\soController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect('login');
});

Route::get('/dashboard', function () {
    if (Auth::user()->role == 'karyawan') {
        return redirect('karyawan');
    } elseif (Auth::user()->role == 'admin') {
        return redirect('admin-home');
    }
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});


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

});
Route::group(['middleware' => ['role:admin']], function () {
    Route::get('admin-home', [adminController::class, 'index']);

    // event controller
    Route::get('event', [eventController::class, 'index']);
    Route::post('event', [eventController::class, 'create']);
});


require __DIR__ . '/auth.php';
