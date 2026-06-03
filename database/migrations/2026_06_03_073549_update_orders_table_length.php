<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            // Contoh penyesuaian ukuran berdasarkan kebutuhan umum
            $table->string('invoice_code', 50)->change();
            $table->string('full_name', 50)->change();
            $table->string('phone_number', 30)->change();
            $table->string('payment_method', 50)->change();
            $table->string('payment_status', 30)->change();
            $table->string('order_status', 30)->change();
        });
    }

    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            // Kembalikan ke 255 jika perlu rollback
            $table->string('invoice_code', 255)->change();
            $table->string('full_name', 255)->change();
            $table->string('phone_number', 255)->change();
            $table->string('payment_method', 255)->change();
            $table->string('payment_status', 255)->change();
            $table->string('order_status', 255)->change();
        });
    }
};