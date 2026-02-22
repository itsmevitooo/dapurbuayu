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
        Schema::table('products', function (Blueprint $table) {
            // Hapus kolom side_dish jika ada
            if (Schema::hasColumn('products', 'side_dish')) {
                $table->dropColumn('side_dish');
            }
            
            // Hapus kolom items jika ada (karena sudah pindah ke PaketDetail)
            if (Schema::hasColumn('products', 'items')) {
                $table->dropColumn('items');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->text('side_dish')->nullable();
            $table->json('items')->nullable();
        });
    }
};