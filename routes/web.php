<?php

use App\Http\Controllers\{AuthController, CetakController, CrudController, DashboardController, NotaController};
use Illuminate\Support\Facades\Route;

Route::view('/', 'home')->name('home');

Route::get('/login', [AuthController::class, 'form'])->name('login');
Route::post('/login', [AuthController::class, 'login']);

Route::middleware('auth')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::resource('nota', NotaController::class)->parameters(['nota' => 'nota'])->except('show');

    Route::get('/cetak/laporan', [CetakController::class, 'laporan'])->name('cetak.laporan');
    Route::get('/cetak/nota/{nota}', [CetakController::class, 'nota'])->name('cetak.nota');

    Route::prefix('data/{t}')->where(['t' => 'pemilik|hewan|layanan|dokter'])->group(function () {
        Route::get('/', [CrudController::class, 'index'])->name('data.index');
        Route::post('/', [CrudController::class, 'store'])->name('data.store');
        Route::put('/{id}', [CrudController::class, 'update'])->name('data.update');
        Route::delete('/{id}', [CrudController::class, 'destroy'])->name('data.destroy');
    });
});
