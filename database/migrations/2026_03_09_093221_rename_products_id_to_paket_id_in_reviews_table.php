<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('reviews', function (Blueprint $table) {
            // Mengubah nama kolom dari products_id menjadi paket_id
            if (Schema::hasColumn('reviews', 'products_id')) {
                $table->renameColumn('products_id', 'paket_id');
            }
        });
    }

    public function down(): void
    {
        Schema::table('reviews', function (Blueprint $table) {
            // Kebalikan jika ingin di-rollback
            if (Schema::hasColumn('reviews', 'paket_id')) {
                $table->renameColumn('paket_id', 'products_id');
            }
        });
    }
};