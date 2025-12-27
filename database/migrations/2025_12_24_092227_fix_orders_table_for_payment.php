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
            // Menambahkan kolom yang dibutuhkan jika belum ada
            if (!Schema::hasColumn('orders', 'payment_method')) {
                $table->string('payment_method')->after('total_price');
            }
            
            if (!Schema::hasColumn('orders', 'payment_deadline')) {
                $table->dateTime('payment_deadline')->nullable()->after('delivery_date');
            }
    
            if (!Schema::hasColumn('orders', 'snap_token')) {
                $table->string('snap_token')->nullable()->after('payment_method');
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
