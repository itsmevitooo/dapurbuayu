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
     * RELASI DIBERESIN DISINI
     * Kita pakai Paket::class karena itu nama file model kamu!
     */
    public function product()
    {
        return $this->belongsTo(Paket::class, 'paket_id');
    }
}