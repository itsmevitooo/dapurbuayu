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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->string('invoice_code')->unique();
            $table->string('full_name');
            $table->string('phone_number');
            $table->date('delivery_date'); // Filament kamu pakai format date()
            $table->text('address');
            $table->integer('total_price');
            $table->string('payment_method');
            $table->string('payment_status')->default('PENDING');
            $table->string('order_status')->default('DIPROSES');
            $table->timestamps();
        });
    }
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
