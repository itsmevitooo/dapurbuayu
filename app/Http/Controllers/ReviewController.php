<?php

namespace App\Http\Controllers;

use App\Models\Review;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    public function index()
    {
        // Hanya ambil yang sudah diapprove jika perlu, atau semua seperti di bawah:
        $reviews = Review::latest()->get();
        return view('reviews', compact('reviews'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'required|string',
            'image.*' => 'nullable|image|mimes:jpeg,png,jpg|max:2048', 
        ]);

        $imagePaths = [];
        // PERBAIKAN: Menggunakan 'image' sesuai dengan name="image[]" di Blade
        if ($request->hasFile('image')) {
            foreach ($request->file('image') as $file) {
                // Menyimpan ke storage/app/public/reviews
                $imagePaths[] = $file->store('reviews', 'public');
            }
        }

        Review::create([
            'name' => $request->name,
            'rating' => $request->rating,
            'comment' => $request->comment,
            'image' => $imagePaths, // Tersimpan sebagai array JSON di DB
            'is_approved' => 0,
        ]);

        return redirect()->back()->with('success', 'Review berhasil dikirim!');
    }
}