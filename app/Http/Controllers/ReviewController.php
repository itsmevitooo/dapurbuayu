<?php

namespace App\Http\Controllers;

use App\Models\Review;
// Gallery sudah tidak perlu di-import jika hanya digunakan untuk store review
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    public function index()
    {
        $reviews = Review::latest()->get();
        return view('reviews', compact('reviews'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'required|string',
            'images.*' => 'nullable|image|mimes:jpeg,png,jpg|max:2048', // Validasi tiap file
        ]);

        $imagePaths = [];
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $imagePaths[] = $image->store('reviews', 'public');
            }
        }

        Review::create([
            'name' => $request->name,
            'rating' => $request->rating,
            'comment' => $request->comment,
            'image' => $imagePaths, // Simpan sebagai array
        ]);

        return redirect()->back()->with('success', 'Review berhasil dikirim!');
    }
}