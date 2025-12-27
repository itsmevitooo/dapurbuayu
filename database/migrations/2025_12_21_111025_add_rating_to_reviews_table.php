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
        Schema::table('reviews', function (Blueprint $table) {
            // Menambah kolom rating
            $table->integer('rating')->default(5)->after('comment');
            
            // Mengubah default is_approved menjadi true (1)
            // Kita gunakan change() untuk memodifikasi kolom yang sudah ada
            $table->boolean('is_approved')->default(true)->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('reviews', function (Blueprint $table) {
            $table->dropColumn('rating');
            // Kembalikan ke false jika di-rollback
            $table->boolean('is_approved')->default(false)->change();
        });
    }
};