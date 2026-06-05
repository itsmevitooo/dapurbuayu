<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Gallery extends Model
{
    protected $table = 'galleries'; 
    
    protected $fillable = ['review_id', 'image', 'category', 'title', 'description', 'uploaded_by'];

    public function review()
    {
        return $this->belongsTo(Review::class, 'review_id');
    }
}