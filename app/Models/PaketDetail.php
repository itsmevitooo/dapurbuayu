<?php

namespace App\Models;

// app/Models/PaketDetail.php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PaketDetail extends Model
{
    // Menghubungkan model PaketDetail ke tabel package_details
    protected $table = 'package_details';

    protected $fillable = ['product_id', 'name'];

    public function paket()
    {
        return $this->belongsTo(Paket::class, 'product_id');
    }
}