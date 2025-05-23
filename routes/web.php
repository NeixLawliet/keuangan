<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\KeuanganController;
use App\Http\Controllers\InventoryController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\LaporanController;
use Illuminate\Support\Facades\Route;

// Halaman login
Route::get('/', [AuthController::class, 'index'])->name('login');
Route::get('/login', [AuthController::class, 'index'])->name('login');
Route::post('/login', [AuthController::class, 'store']); // Proses login

// Custom Logout Route
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Route yang membutuhkan autentikasi
Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::get('/keuangan', [KeuanganController::class, 'index'])->name('keuangan.index');
    Route::get('/keuangan/create', [KeuanganController::class, 'create'])->name('keuangan.create');
    Route::post('/keuangan', [KeuanganController::class, 'store'])->name('keuangan.store');
    Route::get('/keuangan/{id}', [KeuanganController::class, 'show'])->name('keuangan.show');
    Route::get('/keuangan/{id}/edit', [KeuanganController::class, 'edit'])->name('keuangan.edit');
    Route::put('/keuangan/{id}', [KeuanganController::class, 'update'])->name('keuangan.update');
    Route::delete('/keuangan/{id}', [KeuanganController::class, 'destroy'])->name('keuangan.destroy');

    Route::get('/inventory', [InventoryController::class, 'index'])->name('inventory.index');
    Route::get('/inventory/create', [InventoryController::class, 'create'])->name('inventory.create');
    Route::post('/inventory', [InventoryController::class, 'store'])->name('inventory.store');
    Route::get('/inventory/{id}', [InventoryController::class, 'show'])->name('inventory.show');
    Route::get('/inventory/{id}/edit', [InventoryController::class, 'edit'])->name('inventory.edit');
    Route::put('/inventory/{id}', [InventoryController::class, 'update'])->name('inventory.update');
    Route::delete('/inventory/{id}', [InventoryController::class, 'destroy'])->name('inventory.destroy');
    Route::get('/inventory/keluar/create', [InventoryController::class, 'keluar'])->name('inventory.keluar.create');
    Route::post('/inventory/keluar/store', [InventoryController::class, 'storeKeluar'])->name('inventory.keluar.store');
    Route::get('/inventory/download-csv', [InventoryController::class, 'downloadCsv'])->name('inventory.download_csv');


    Route::middleware('auth')->group(function () {
        Route::get('/profile', [ProfileController::class, 'showProfile'])->name('profile.show');
        Route::put('/profile', [ProfileController::class, 'updateProfile'])->name('profile.update');
    });

    Route::get('/laporan', [LaporanController::class, 'index'])->name('laporan.index');
    Route::get('/laporan/pdf-transaksi', [LaporanController::class, 'downloadTransaksiPDF'])->name('laporan.pdf_transaksi');
    Route::get('/laporan/pdf-barang', [LaporanController::class, 'downloadBarangPDF'])->name('laporan.pdf_barang');
    Route::get('/laporan/barang/excel', [LaporanController::class, 'downloadBarangExcel'])->name('laporan.barang.excel');
    Route::get('/laporan/transaksi/excel', [LaporanController::class, 'downloadTransaksiExcel'])->name('laporan.transaksi.excel');


});




