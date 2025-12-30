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
        // Mengambil 4 data terlaris dari model Paket (yang nyambung ke tabel products)
        $packages = \App\Models\Paket::orderBy('total_orders', 'desc')
            ->take(4)
            ->get(); 
    
        $reviews = \App\Models\Review::where('is_approved', true)
            ->latest()
            ->take(4) 
            ->get();
        
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