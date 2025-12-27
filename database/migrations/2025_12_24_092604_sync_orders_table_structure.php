<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
{
    Schema::table('orders', function (Blueprint $table) {
        // 1. Hapus kolom order_type karena kita menggunakan payment_method
        if (Schema::hasColumn('orders', 'order_type')) {
            $table->dropColumn('order_type');
        }

        // 2. Tambah payment_method jika belum ada
        if (!Schema::hasColumn('orders', 'payment_method')) {
            $table->string('payment_method')->after('total_price');
        }

        // 3. Tambah snap_token untuk Midtrans jika belum ada
        if (!Schema::hasColumn('orders', 'snap_token')) {
            $table->string('snap_token')->nullable()->after('payment_method');
        }
        
        // 4. Pastikan payment_deadline ada
        if (!Schema::hasColumn('orders', 'payment_deadline')) {
            $table->dateTime('payment_deadline')->nullable()->after('delivery_date');
        }
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            //
        });
    }
};
