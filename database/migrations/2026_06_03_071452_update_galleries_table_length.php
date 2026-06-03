<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('galleries', function (Blueprint $table) {
            $table->string('image', 150)->change();
            $table->string('title', 100)->change();
            $table->string('category', 50)->change();
        });
    }

    public function down(): void
    {
        Schema::table('galleries', function (Blueprint $table) {
            // Kembalikan ke 255 jika ingin dibatalkan (rollback)
            $table->string('image', 255)->change();
            $table->string('title', 255)->change();
            $table->string('category', 255)->change();
        });
    }
};