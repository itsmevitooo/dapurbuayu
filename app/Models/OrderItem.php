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
        'item_name', // WAJIB ADA DI SINI
        'quantity',
        'price',
        'subtotal',
        'side_dish',
    ];

    protected $casts = [
        'side_dish' => 'array',
    ];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function product()
    {
        return $this->belongsTo(Paket::class, 'paket_id');
    }
}