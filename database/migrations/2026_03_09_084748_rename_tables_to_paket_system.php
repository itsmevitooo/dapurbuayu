<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // 1. Rename Tabel Utama (Pastikan pakai 'products' dengan S)
        if (Schema::hasTable('products')) {
            Schema::rename('products', 'paket');
        }
        
        if (Schema::hasTable('package_details')) {
            Schema::rename('package_details', 'paketdetail');
        }
    
        // 2. Rename Kolom Foreign Key di tabel paketdetail
        if (Schema::hasTable('paketdetail')) {
            Schema::table('paketdetail', function (Blueprint $table) {
                // Kita ubah dari product_id menjadi paket_id
                if (Schema::hasColumn('paketdetail', 'product_id')) {
                    $table->renameColumn('product_id', 'paket_id');
                }
            });
        }
    
        // 3. Rename Kolom Foreign Key di tabel lain (order_items)
        if (Schema::hasTable('order_items')) {
            Schema::table('order_items', function (Blueprint $table) {
                if (Schema::hasColumn('order_items', 'product_id')) {
                    $table->renameColumn('product_id', 'paket_id');
                }
            });
        }
    
        // 4. Rename Kolom Foreign Key di tabel lain (reviews)
        if (Schema::hasTable('reviews')) {
            Schema::table('reviews', function (Blueprint $table) {
                if (Schema::hasColumn('reviews', 'product_id')) {
                    $table->renameColumn('product_id', 'paket_id');
                }
            });
        }
    }

    public function down(): void
    {
        // Kebalikan untuk rollback
        if (Schema::hasTable('paket')) {
            Schema::rename('paket', 'products');
        }

        if (Schema::hasTable('paketdetail')) {
            Schema::table('paketdetail', function (Blueprint $table) {
                $table->renameColumn('paket_id', 'product_id');
            });
            Schema::rename('paketdetail', 'package_details');
        }
    }
};