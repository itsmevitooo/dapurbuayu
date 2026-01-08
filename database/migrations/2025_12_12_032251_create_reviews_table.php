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
        Schema::create('reviews', function (Blueprint $table) {
            $table->id();
            // Relasi ke products (Model Paket)
            $table->foreignId('products_id')->constrained('products')->onDelete('cascade');
            $table->string('name');
            $table->integer('rating');
            $table->text('comment')->nullable();
            $table->boolean('is_approved')->default(false); // Sesuai IconColumn di Filament
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reviews');
    }
};
