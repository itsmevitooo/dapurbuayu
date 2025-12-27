<?php

namespace App\Http\Controllers;

use App\Models\Review;
use App\Models\Gallery;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    // TAMBAHKAN INI MASSEH
    public function index()
    {
        // Mengambil semua review, urutkan dari yang terbaru
        $reviews = Review::latest()->get();
        
        // Arahkan ke file view (pastikan file resources/views/reviews.blade.php sudah ada)
        return view('reviews', compact('reviews'));
    }

    public function store(Request $request)
    {
        // ... kode store yang tadi sudah kita buat ...
        $request->validate([
            'name' => 'required|string|max:255',
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('reviews', 'public');

            Gallery::create([
                'title' => 'Review dari ' . $request->name,
                'image' => $imagePath,
                'category' => 'customer',
                'description' => $request->comment,
                'uploaded_by' => $request->name,
            ]);
        }

        Review::create([
            'name' => $request->name,
            'rating' => $request->rating,
            'comment' => $request->comment,
            'image' => $imagePath,
        ]);

        return redirect()->back()->with('success', 'Review berhasil dikirim!');
    }
}