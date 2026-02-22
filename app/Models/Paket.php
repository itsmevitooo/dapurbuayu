<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Paket extends Model
{
    // Mengarahkan model ke tabel products
    protected $table = 'products'; 

    protected $fillable = [
        'name', 
        'category', 
        'min_order', 
        'price', 
        'image',
        'description',
        'total_orders'
    ];

    public function details(): HasMany
    {
        return $this->hasMany(PaketDetail::class, 'product_id');
    }
}