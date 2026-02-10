<?php

namespace App\Http\Controllers;

use App\Models\Paket; 
use App\Models\Review;
use App\Models\Gallery; 
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        // Ambil 4 paket terlaris
        $packages = Paket::orderBy('total_orders', 'desc')
            ->take(4)
            ->get(); 
    
        // Ambil 3 review terbaru (Tanpa filter is_approved agar langsung muncul)
        $reviews = Review::latest()
            ->take(3) 
            ->get();
        
        // Kita pakai 'welcome' agar sesuai dengan file blade kamu
        return view('welcome', compact('packages', 'reviews')); 
    }

    public function gallery() 
    { 
        $galleries = Gallery::latest()->get();
        return view('gallery', compact('galleries')); 
    }

    public function location() 
    { 
        return view('location'); 
    }
}