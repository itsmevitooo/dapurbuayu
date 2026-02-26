<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\OrderController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
*/

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

/**
 * Route khusus untuk menerima notifikasi otomatis dari Midtrans (Webhook)
 * Pastikan URL ini sudah didaftarkan di Dashboard Midtrans:
 * https://catherina-pseudoaesthetic-krystin.ngrok-free.dev/api/midtrans-callback
 */
Route::post('/midtrans-callback', [OrderController::class, 'callback']);