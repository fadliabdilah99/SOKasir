<?php

use App\Http\Controllers\karyawanController;
use App\Http\Controllers\kategoriController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect('login');
});

Route::get('/dashboard', function () {
    return view('error');
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
});


require __DIR__.'/auth.php';
