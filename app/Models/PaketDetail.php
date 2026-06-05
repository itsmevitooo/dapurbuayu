<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PaketDetail extends Model
{
    protected $table = 'paketdetail';

    protected $fillable = [
        'paket_id',
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
        return $this->belongsTo(Paket::class, 'paket_id');
    }
}