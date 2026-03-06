<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('reviews', function (Blueprint $table) {
            // Mengubah kolom menjadi NOT NULL dan menghubungkannya sebagai Foreign Key
            $table->foreignId('products_id')->nullable(false)->change();
            
            // Opsional: Jika belum ada relasi resmi di level DB
            // $table->foreign('products_id')->references('id')->on('products')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::table('reviews', function (Blueprint $table) {
            $table->foreignId('products_id')->nullable(true)->change();
        });
    }
};