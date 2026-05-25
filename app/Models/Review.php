<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Review extends Model
{
    use HasFactory;

    protected $fillable = [
        'paket_id', 'name', 'comment', 'rating', 'image', 'is_approved'
    ];

    protected $casts = [
        'image' => 'array',
    ];

    protected static function booted()
    {
        static::deleting(function ($model) {
            if (is_array($model->image)) {
                foreach ($model->image as $img) {
                    Storage::disk('public')->delete($img);
                }
            }
        });

        static::updating(function ($model) {
            if ($model->isDirty('image')) {
                $oldImages = $model->getOriginal('image');
                if (is_array($oldImages)) {
                    foreach ($oldImages as $img) {
                        Storage::disk('public')->delete($img);
                    }
                }
            }
        });
    }

    public function product()
    {
        return $this->belongsTo(Paket::class, 'products_id');
    }

    public function gallery()
    {
        return $this->hasMany(\App\Models\Gallery::class, 'review_id');
    }
}