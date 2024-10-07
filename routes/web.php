<?php

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
        return redirect('admin');
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

    // so controller
    Route::post('so', [soController::class, 'create']);
    Route::delete('so/{id}', [soController::class, 'destroy']);
});


require __DIR__ . '/auth.php';
