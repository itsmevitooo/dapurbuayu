<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::table('products', function (Blueprint $table) {
            if (Schema::hasColumn('products', 'side_dish')) {
                $table->dropColumn('side_dish');
            }
            if (Schema::hasColumn('products', 'items')) {
                $table->dropColumn('items');
            }
        });
    }

    public function down(): void {
        Schema::table('products', function (Blueprint $table) {
            $table->text('side_dish')->nullable();
            $table->json('items')->nullable();
        });
    }
};