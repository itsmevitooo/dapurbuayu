<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\PaketController;
use App\Http\Controllers\CheckOrderController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\OrderController; // Tambahkan ini
use Illuminate\Support\Facades\Route;

// --- Halaman Utama & Umum ---
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/lokasi', [HomeController::class, 'location'])->name('location');
Route::get('/galeri', [HomeController::class, 'gallery'])->name('gallery.index');

// --- Sistem Review ---
Route::get('/reviews', [ReviewController::class, 'index'])->name('reviews.index');
Route::post('/reviews', [ReviewController::class, 'store'])->name('reviews.store');

// --- Katalog & Detail Order ---
Route::get('/paket', [PaketController::class, 'index'])->name('paket.index');
// Route ini yang dipanggil tombol "Pilih Paket"
Route::get('/paket/detail/{id}', [OrderController::class, 'showDetailForm'])->name('paket.detail');

// --- Proses Transaksi ---
Route::prefix('checkout')->name('order.')->group(function () {
    Route::post('/process-detail', [OrderController::class, 'processDetail'])->name('process_detail');
    Route::get('/pembayaran', [OrderController::class, 'showPayment'])->name('payment');
    Route::post('/proses-final', [OrderController::class, 'processPayment'])->name('process_payment');
});

// --- Fitur Lacak Pesanan ---
Route::prefix('cek-order')->name('check_order.')->controller(CheckOrderController::class)->group(function () {
    Route::get('/', 'index')->name('index'); 
    Route::get('/search', 'search')->name('search')->middleware('throttle:5,2');
});