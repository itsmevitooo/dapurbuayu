<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_id',
        'item_name',
        'quantity',
        'price_per_item',
        'side_dish',
    ];

    // Otomatis konversi json side_dish menjadi array saat diakses
    protected $casts = [
        'side_dish' => 'array',
    ];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }
}