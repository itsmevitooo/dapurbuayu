<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    use HasFactory;

    protected $fillable = [
        'paket_id', 
        'name', 
        'comment', 
        'rating', 
        'image', 
        'is_approved'
    ];

    protected $casts = [
        'image' => 'array',
    ];

    public function product()
    {
        // Tetap menggunakan Paket::class karena nama model produk Mas adalah Paket
        return $this->belongsTo(Paket::class, 'products_id');
    }
}