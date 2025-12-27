<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\CheckOrderController;
use App\Http\Controllers\ReviewController;
use Illuminate\Support\Facades\Route;

// --- Halaman Umum ---
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/lokasi', [HomeController::class, 'location'])->name('location');

// Halaman Galeri (Menggunakan HomeController sesuai kode Mas di atas)
Route::get('/galeri', [HomeController::class, 'gallery'])->name('gallery.index');

// --- Review System ---
// Menampilkan semua review (Halaman khusus daftar review)
Route::get('/reviews', [ReviewController::class, 'index'])->name('reviews.index');
// Menyimpan review baru (Diproses oleh ReviewController agar support upload foto)
Route::post('/reviews', [ReviewController::class, 'store'])->name('reviews.store');


// --- 1. Proses Order ---
Route::prefix('order')->name('order.')->group(function () {
    Route::get('/', [OrderController::class, 'selectType'])->name('select_type');
    Route::get('/paket/{type}', [OrderController::class, 'selectPackage'])->name('select_package');
    Route::get('/detail/{package_id}', [OrderController::class, 'showDetailForm'])->name('show_detail');
    Route::post('/detail', [OrderController::class, 'processDetail'])->name('process_detail');
    Route::get('/payment', [OrderController::class, 'showPayment'])->name('show_payment'); 
    Route::post('/process-payment', [OrderController::class, 'processPayment'])->name('process_payment');
    Route::get('/success', [OrderController::class, 'success'])->name('success');
});

// --- 2. Cek Order ---
Route::prefix('cek-order')->name('check_order.')->controller(CheckOrderController::class)->group(function () {
    Route::get('/', 'index')->name('index'); 
    Route::get('/search', 'search')
        ->name('search')
        ->middleware('throttle:5,2');
});