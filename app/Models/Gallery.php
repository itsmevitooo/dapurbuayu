<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Gallery extends Model
{
    // Menggunakan nama tabel yang benar: 'galleries'
    protected $table = 'galleries'; 
    
    protected $fillable = ['review_id', 'image', 'category', 'title'];

    public function review()
    {
        return $this->belongsTo(Review::class, 'review_id');
    }
}