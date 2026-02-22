<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PaketDetail extends Model
{
    // Mengacu pada tabel di database Mas
    protected $table = 'package_details';

    // Bersihkan fillable (jangan ada double 'name')
    protected $fillable = [
        'product_id', 
        'category', 
        'name', 
        'is_selectable'
    ];

    /**
     * SANGAT PENTING:
     * Karena di Filament Mas pakai inputan yang bisa diisi banyak (tags/multiple),
     * Laravel harus mengubah data JSON dari database menjadi Array PHP secara otomatis.
     */
    protected $casts = [
        'name' => 'array', 
        'is_selectable' => 'boolean',
    ];

    public function paket()
    {
        return $this->belongsTo(Paket::class, 'product_id');
    }
}