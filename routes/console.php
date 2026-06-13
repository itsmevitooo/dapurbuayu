<?php

use App\Models\Order;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

Artisan::command('inspire', function () {
    $this->comment(\Illuminate\Foundation\Inspiring::quote());
})->purpose('Display an inspiring quote');

/**
 * Automasi Pembatalan Pesanan:
 * Jika payment_deadline (H-2 dari delivery) sudah lewat dan masih PENDING, maka DITOLAK.
 */
Schedule::call(function () {
    $now = Carbon::now();

    $affectedRows = Order::where('payment_status', 'PENDING')
        ->where('payment_deadline', '<', $now)
        ->update([
            'payment_status' => 'DIBATALKAN',
            'order_status'   => 'DITOLAK'
        ]);

    if ($affectedRows > 0) {
        Log::info("Automasi: Berhasil membatalkan $affectedRows pesanan karena melewati payment_deadline.");
    }
})->everyMinute();