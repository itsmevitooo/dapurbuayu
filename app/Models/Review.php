<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    use HasFactory;

    protected $fillable = [
        'paket_id', 'name', 'comment', 'rating'
    ];

    public function product()
    {
        return $this->belongsTo(Paket::class, 'paket_id'); 
    }

    public function gallery()
    {
        return $this->hasMany(Gallery::class, 'review_id');
    }
}