<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Paket; 
use App\Models\Review;
use App\Models\Gallery; 
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        // 1. Ambil data paket (menggunakan model Paket sesuai instruksi Mas)
        $packages = Paket::all(); 

        // 2. Ambil review yang sudah disetujui
        $reviews = Review::where('is_approved', true)
            ->orderByDesc('created_at')
            ->get();
        
        // 3. KEMBALIKAN KE WELCOME (Sesuai file asli Mas)
        return view('welcome', compact('packages', 'reviews')); 
    }

    public function gallery() 
    { 
        // Ambil data untuk halaman galeri
        $galleries = Gallery::orderByDesc('created_at')->get();

        return view('gallery', compact('galleries')); 
    }

    public function location() 
    { 
        return view('location'); 
    }
}