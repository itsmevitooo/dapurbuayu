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
        Schema::create('galleries', function (Blueprint $table) {
            $table->id();
            $table->string('title')->nullable(); 
            $table->string('image'); 
            $table->string('category')->default('admin'); // 'admin' atau 'customer'
            $table->text('description')->nullable();
            
            // Relasi opsional ke review jika foto berasal dari feedback user
            $table->foreignId('review_id')->nullable()->constrained()->onDelete('set null');
            $table->string('uploaded_by')->nullable(); // Nama pengirim (untuk foto user)
            
            $table->timestamps();
        });
    }
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('galleries');
    }
};
