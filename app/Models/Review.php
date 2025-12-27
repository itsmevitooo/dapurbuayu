<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    use HasFactory;

    // Tambahkan 'rating' di sini
    protected $fillable = ['name', 'comment', 'rating', 'image', 'is_approved'];
}