<?php

namespace App\Http\Controllers;

use App\Models\Paket; // Menggunakan model Paket sesuai permintaan Filament
use App\Models\Review;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        // Ambil data dari tabel paket
        $packages = Paket::all();
        
        // Ambil review tanpa filter approval agar langsung muncul
        $reviews = Review::latest()->get();

        return view('welcome', compact('packages', 'reviews'));
    }

    public function storeReview(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'rating' => 'required|integer',
            'comment' => 'required',
            'image.*' => 'image|mimes:jpeg,png,jpg|max:2048'
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
            'image' => $imagePaths, // Simpan sebagai array (pastikan cast array di Model)
        ]);

        return back()->with('success', 'Review berhasil dikirim!');
    }
}