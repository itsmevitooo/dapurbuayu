<?php

namespace App\Http\Controllers;

use App\Models\Gallery;
use Illuminate\Http\Request;

class GalleryController extends Controller
{
    public function index()
    {
        // Mengambil semua data galeri beserta data review-nya (Eager Loading)
        // 'latest()' agar yang terbaru muncul lebih dulu
        $galleries = Gallery::with('review')->latest()->get();
        
        return view('gallery', compact('galleries'));
    }
}