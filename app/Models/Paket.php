<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Paket extends Model
{
    use HasFactory;

    // WAJIB: Karena nama model (Paket) beda dengan nama tabel (products)
    protected $table = 'products';

    protected $fillable = [
        'name',
        'price',
        'image', // Pastikan sudah huruf kecil
        'items',
        'min_order',
    ];

    protected $casts = [
        'items' => 'array', // Supaya data JSON menu bisa diinput/diedit
    ];
}