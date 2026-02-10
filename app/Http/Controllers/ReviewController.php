<?php

namespace App\Http\Controllers;

use App\Models\Review;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    public function index()
    {
        // Mengambil semua review terbaru tanpa filter approval
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
        if ($request->hasFile('image')) {
            foreach ($request->file('image') as $file) {
                $imagePaths[] = $file->store('reviews', 'public');
            }
        }

        Review::create([
            'name' => $request->name,
            'rating' => $request->rating,
            'comment' => $request->comment,
            'image' => $imagePaths,
            // 'is_approved' dihapus dari sini
        ]);

        return redirect()->back()->with('success', 'Review Anda telah berhasil diterbitkan!');
    }
}