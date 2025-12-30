<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Paket; // Menggunakan model Paket (tabel: paket)
use App\Models\Review;
use App\Models\Gallery; 
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Menampilkan Halaman Beranda (Welcome)
     */
    public function index()
    {
        // 1. Ambil data dari tabel 'paket'
        $packages = Paket::all(); 

        // 2. Ambil review yang sudah disetujui, urutkan dari yang terbaru
        $reviews = Review::where('is_approved', true)
            ->latest()
            ->get();
        
        // 3. Mengarahkan ke resources/views/welcome.blade.php
        return view('welcome', compact('packages', 'reviews')); 
    }

    /**
     * Menampilkan Halaman Galeri Foto
     */
    public function gallery() 
    { 
        // Mengambil foto galeri (bisa diunggah user/admin sesuai info tersimpan)
        $galleries = Gallery::latest()->get();

        return view('gallery', compact('galleries')); 
    }

    /**
     * Menampilkan Halaman Lokasi / Kontak
     */
    public function location() 
    { 
        return view('location'); 
    }
}