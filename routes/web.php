<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

// Halaman utama diarahkan ke form login
Route::get('/', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Rute yang dilindungi (Hanya bisa diakses jika sudah login)
Route::middleware('auth')->group(function () {
    // Halaman Dashboard
    Route::get('/dashboard', function () {
        return view('layouts.app'); // Untuk sementara dashboard menampilkan template kosong
    })->name('dashboard');

    // Halaman Master Kategori
    Route::get('/kategori', [App\Http\Controllers\CategoryController::class, 'index']);
    Route::post('/kategori', [App\Http\Controllers\CategoryController::class, 'store']);
    Route::get('/kategori/hapus/{id}', [App\Http\Controllers\CategoryController::class, 'destroy']);
    // Halaman Master Barang
    Route::get('/barang', [App\Http\Controllers\ItemController::class, 'index']);
    Route::post('/barang', [App\Http\Controllers\ItemController::class, 'store']);
    Route::get('/barang/hapus/{id}', [App\Http\Controllers\ItemController::class, 'destroy']);
    // Master Data Klien (SPPG)
    Route::get('/klien', [App\Http\Controllers\ClientController::class, 'index']);
    Route::post('/klien', [App\Http\Controllers\ClientController::class, 'store']);
    Route::get('/klien/hapus/{id}', [App\Http\Controllers\ClientController::class, 'destroy']);

    // Halaman Transaksi Keluar/Masuk
    Route::get('/transaksi', [App\Http\Controllers\TransactionController::class, 'index']);
    Route::post('/transaksi', [App\Http\Controllers\TransactionController::class, 'store']);
    // Halaman Dashboard Utama
    Route::get('/dashboard', [App\Http\Controllers\DashboardController::class, 'index'])->name('dashboard');
    // Modul Laporan & Ekspor
    Route::get('/laporan', [App\Http\Controllers\ReportController::class, 'index']);
    Route::get('/laporan/pdf', [App\Http\Controllers\ReportController::class, 'exportPdf']);
    Route::get('/laporan/excel', [App\Http\Controllers\ReportController::class, 'exportExcel']);
    // Manajemen Akun Operator
    Route::get('/users', [App\Http\Controllers\UserController::class, 'index']);
    Route::post('/users', [App\Http\Controllers\UserController::class, 'store']);
    Route::get('/users/toggle/{id}', [App\Http\Controllers\UserController::class, 'toggleStatus']);
});