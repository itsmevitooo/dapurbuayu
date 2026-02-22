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
        // Tambahkan pengecekan if !Schema::hasColumn agar tidak error duplicate
        if (!Schema::hasColumn('order_items', 'side_dish')) {
            Schema::table('order_items', function (Blueprint $table) {
                $table->text('side_dish')->nullable(); // Untuk menyimpan daftar lauk
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('order_items', function (Blueprint $table) {
            // Di sini harusnya dropColumn, bukan menambah lagi
            if (Schema::hasColumn('order_items', 'side_dish')) {
                $table->dropColumn('side_dish');
            }
        });
    }
};