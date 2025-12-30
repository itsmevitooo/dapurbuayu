<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\PaketController;
use App\Http\Controllers\CheckOrderController;
use App\Http\Controllers\ReviewController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes - Dapur Bu Ayu (Revisi 2025)
|--------------------------------------------------------------------------
*/

// --- Halaman Utama & Umum ---
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/lokasi', [HomeController::class, 'location'])->name('location');
Route::get('/galeri', [HomeController::class, 'gallery'])->name('gallery.index');

// --- Sistem Review ---
Route::get('/reviews', [ReviewController::class, 'index'])->name('reviews.index');
Route::post('/reviews', [ReviewController::class, 'store'])->name('reviews.store');

// --- Katalog Paket (Nasi Box, Prasmanan, Tumpeng, Akikah) ---
Route::controller(PaketController::class)->group(function () {
    // Daftar semua paket / filter kategori
    Route::get('/paket', 'index')->name('paket.index');
    
    // Detail paket (PENTING: Gunakan nama 'paket.detail' agar sinkron dengan tombol di Home)
    Route::get('/paket/detail/{id}', 'show')->name('paket.detail');
});

// --- Proses Transaksi / Checkout ---
Route::prefix('checkout')->name('checkout.')->group(function () {
    Route::post('/tambah/{id}', [PaketController::class, 'addToCart'])->name('add_to_cart');
    Route::get('/pembayaran', [PaketController::class, 'showPayment'])->name('payment');
    Route::post('/proses', [PaketController::class, 'process'])->name('process');
    Route::get('/success', [PaketController::class, 'success'])->name('success');
});

// --- Fitur Lacak Pesanan ---
Route::prefix('cek-order')->name('check_order.')->controller(CheckOrderController::class)->group(function () {
    Route::get('/', 'index')->name('index'); 
    Route::get('/search', 'search')
        ->name('search')
        ->middleware('throttle:5,2');
});