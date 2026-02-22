<?php

// app/Models/Paket.php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Paket extends Model
{
    protected $table = 'products';

    protected $fillable = [
        'name', 'category', 'price', 'min_order', 'image', 'total_orders',
    ];

    // Relasi ke PaketDetail
    public function details(): HasMany
    {
        return $this->hasMany(PaketDetail::class, 'product_id');
    }
}