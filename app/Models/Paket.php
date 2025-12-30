<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Paket extends Model
{
    use HasFactory;

    protected $table = 'products';

    protected $fillable = [
        'name', 
        'category', 
        'price', 
        'min_order', 
        'image', 
        'items', 
        'total_orders',
    ];

    protected $casts = [
        'items' => 'array',
    ];
}