<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthKasirController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\BarangController;
use App\Http\Controllers\TransaksiController;
use App\Http\Controllers\LaporanController;

// ==========================
//  LOGIN / LOGOUT
// ==========================

// Redirect root ke login
Route::get('/', function () {
    return redirect()->route('kasir.login');
});

// Halaman login kasir
Route::get('/kasir/login', [AuthKasirController::class, 'showLoginForm'])->name('kasir.login');

// Proses login kasir
Route::post('/kasir/login', [AuthKasirController::class, 'login'])->name('kasir.login.post');

// Proses logout
Route::post('/kasir/logout', [AuthKasirController::class, 'logout'])->name('kasir.logout');

// ==========================
//  Protected routes (auth:kasir)
// ==========================
Route::middleware('auth:kasir')->group(function () {

    // Dashboard utama
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('kasir.dashboard');

    // Kategori (CRUD resource)
    Route::resource('kategori', KategoriController::class)->except(['show', 'create', 'edit']);

    // Barang (CRUD resource)
    Route::resource('barang', BarangController::class)->except(['show', 'create', 'edit']);

    Route::get('/transaksi', [TransaksiController::class, 'index'])->name('transaksi.index');
    Route::post('/transaksi', [TransaksiController::class, 'store'])->name('transaksi.store');
    Route::get('/laporan', [LaporanController::class, 'index'])->name('laporan.index');
    Route::get('/laporan/{periode}/detail', [LaporanController::class, 'detail'])->name('laporan.detail');

});
