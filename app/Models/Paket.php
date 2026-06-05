<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Storage;

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

    /**
     * Logika untuk membersihkan file sampah secara otomatis
     */
    protected static function booted()
    {
        // 1. Hapus file fisik saat record Paket dihapus
        static::deleting(function ($paket) {
            if ($paket->image && Storage::disk('public')->exists($paket->image)) {
                Storage::disk('public')->delete($paket->image);
            }
        });

        // 2. Hapus file fisik lama saat foto diganti (update)
        static::updating(function ($paket) {
            if ($paket->isDirty('image')) {
                $oldImage = $paket->getOriginal('image');
                if ($oldImage && Storage::disk('public')->exists($oldImage)) {
                    Storage::disk('public')->delete($oldImage);
                }
            }
        });
    }

    public function details(): HasMany
    {
        return $this->hasMany(PaketDetail::class, 'paket_id');
    }

    public function reviews(): HasMany
    {
        return $this->hasMany(Review::class, 'paket_id');
    }
}