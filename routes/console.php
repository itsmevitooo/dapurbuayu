<?php

use App\Models\Order;
use Illuminate\Foundation\Console\ClosureCommand;
use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;
use Carbon\Carbon;

Artisan::command('inspire', function () {
    /** @var ClosureCommand $this */
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

/**
 * Automasi Pembatalan Pesanan:
 * Mengecek pesanan yang statusnya PENDING dan sudah memasuki H-2 acara.
 * Jika belum dibayar pada H-2, maka otomatis CANCELLED.
 */
Schedule::call(function () {
    // Mencari order yang masih PENDING
    // Dan delivery_date sudah kurang dari atau sama dengan (Hari ini + 2 hari)
    $affectedRows = Order::where('payment_status', 'PENDING')
        ->whereDate('delivery_date', '<=', Carbon::now()->addDays(2))
        ->update([
            'payment_status' => 'CANCELLED',
            'order_status' => 'DITOLAK'
        ]);

    if ($affectedRows > 0) {
        \Log::info("Automasi: Berhasil membatalkan $affectedRows pesanan yang melewati batas H-2.");
    }
})->everyMinute(); // Mengecek setiap menit