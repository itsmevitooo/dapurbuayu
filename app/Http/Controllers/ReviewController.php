<?php

namespace App\Http\Controllers;

use App\Models\Review;
use App\Models\Paket;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    public function index()
    {
        // Eager loading relasi 'product' dari Model Review
        $reviews = Review::with('product')->latest()->get();
        return view('reviews', compact('reviews'));
    }

    public function store(Request $request)
    {
        // VALIDASI: Diubah menggunakan paket_id dan dicek ke tabel paket
        $request->validate([
            'paket_id' => 'required|exists:paket,id', 
            'name'     => 'required|string|max:255',
            'rating'   => 'required|integer|min:1|max:5',
            'comment'  => 'required|string',
            'image.*'  => 'nullable|image|mimes:jpeg,png,jpg|max:2048', 
        ]);

        $imagePaths = [];
        if ($request->hasFile('image')) {
            foreach ($request->file('image') as $file) {
                $imagePaths[] = $file->store('reviews', 'public');
            }
        }

        Review::create([
            'paket_id' => $request->paket_id, // <-- Sinkron menggunakan paket_id
            'name'     => $request->name,
            'rating'   => $request->rating,
            'comment'  => $request->comment,
            'image'    => $imagePaths,
        ]);

        return redirect()->back()->with('success', 'Review Anda telah berhasil diterbitkan!');
    }
}