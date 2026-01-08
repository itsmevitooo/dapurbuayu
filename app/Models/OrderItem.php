<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_id',
        'paket_id',
        'quantity',
        'price',
        'subtotal',
    ];

    protected $casts = [
        'side_dish' => 'array',
    ];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    /**
     * Relasi ke tabel products
     * Masseh ganti 'Paket::class' menjadi 'Product::class' 
     * karena tabelnya sekarang bernama 'products'.
     */
    public function product()
    {
        return $this->belongsTo(Product::class, 'paket_id');
    }
}