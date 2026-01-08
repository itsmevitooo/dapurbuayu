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
        Schema::create('order_items', function (Blueprint $table) {
            $table->id();
            // Menghubungkan ke tabel orders
            $table->foreignId('order_id')->constrained('orders')->onDelete('cascade');
            // Menghubungkan ke tabel paket
            $table->foreignId('paket_id')->constrained('products');
            
            $table->integer('quantity'); // Jumlah yang dibeli
            $table->decimal('price', 15, 2); // Harga satuan saat dibeli (untuk arsip)
            $table->decimal('subtotal', 15, 2); // quantity * price
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order_items');
    }
};
