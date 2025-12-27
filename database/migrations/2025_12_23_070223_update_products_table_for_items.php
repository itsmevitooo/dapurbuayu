<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('products', function (Blueprint $table) {
            // Hapus kolom description jika sebelumnya ada
            if (Schema::hasColumn('products', 'description')) {
                $table->dropColumn('description');
            }
            
            // Tambahkan kolom items bertipe JSON untuk menyimpan daftar menu paket
            $table->json('items')->after('price')->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn('items');
            $table->text('description')->nullable();
        });
    }
};