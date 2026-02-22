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
        Schema::table('package_details', function (Blueprint $table) {
            // Kita tambahkan kolom category setelah product_id
            $table->string('category')->nullable()->after('product_id'); 
        });
    }
    
    public function down(): void
    {
        Schema::table('package_details', function (Blueprint $table) {
            $table->dropColumn('category');
        });
    }
};
