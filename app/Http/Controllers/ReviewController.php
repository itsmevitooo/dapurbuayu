<?php

namespace App\Http\Controllers;

use App\Models\Review;
use App\Models\Gallery;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    public function index()
    {
        // Eager loading relasi gallery dan product agar tidak error
        $reviews = Review::with(['gallery', 'product'])->latest()->get();
        
        // Pastikan ini mengarah ke file 'reviews.blade.php' di resources/views/
        return view('reviews', compact('reviews'));
    }

    public function store(Request $request)
    {
        // ... (code store anda tetap sama) ...
        $request->validate([
            'paket_id' => 'required|exists:paket,id',
            'name'     => 'required|string|max:255',
            'rating'   => 'required|integer|min:1|max:5',
            'comment'  => 'required|string',
            'image.*'  => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $review = Review::create([
            'paket_id' => $request->paket_id,
            'name'     => $request->name,
            'rating'   => $request->rating,
            'comment'  => $request->comment,
        ]);

        if ($request->hasFile('image')) {
            foreach ($request->file('image') as $file) {
                $path = $file->store('gallery', 'public');
                Gallery::create([
                    'review_id' => $review->id,
                    'image'     => $path,
                    'category'  => 'testimoni pelanggan',
                    'title'     => 'Ulasan dari ' . $review->name,
                ]);
            }
        }
        return redirect()->back()->with('success', 'Review berhasil diterbitkan!');
    }
}