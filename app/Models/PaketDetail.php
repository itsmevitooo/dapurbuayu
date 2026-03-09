<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PaketDetail extends Model
{
    // Mengacu pada tabel paketdetail (tanpa underscore)
    protected $table = 'paketdetail';

    protected $fillable = [
        'paket_id', // Sesuaikan dengan foreign key baru
        'category', 
        'name', 
        'is_selectable'
    ];

    protected $casts = [
        'name' => 'array', 
        'is_selectable' => 'boolean',
    ];

    public function paket(): BelongsTo
    {
        // Relasi balik ke model Paket menggunakan paket_id
        return $this->belongsTo(Paket::class, 'paket_id');
    }
}