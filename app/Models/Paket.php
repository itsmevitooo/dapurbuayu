<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Paket extends Model
{
    // Mengarahkan model ke nama tabel baru hasil migrasi
    protected $table = 'paket'; 

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
        // Hubungkan ke PaketDetail menggunakan foreign key baru: paket_id
        return $this->hasMany(PaketDetail::class, 'paket_id');
    }

    public function reviews(): HasMany
    {
        // Menggunakan paket_id hasil migrasi nanti
        return $this->hasMany(Review::class, 'paket_id');
    }
}