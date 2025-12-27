<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'invoice_code', 
        'full_name', 
        'phone_number', 
        'address', 
        'delivery_date', 
        'payment_deadline', // Tambahkan ini agar bisa disimpan lewat Controller
        'event_location', 
        'total_price', 
        'payment_method', 
        'snap_token', 
        'payment_status', 
        'order_status',
    ];

    /**
     * Cast attributes ke tipe data tertentu.
     * Ini penting agar payment_deadline otomatis menjadi objek Carbon.
     */
    protected $casts = [
        'delivery_date' => 'date',
        'payment_deadline' => 'datetime',
    ];

    /**
     * Relasi ke OrderItem
     */
    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }
}