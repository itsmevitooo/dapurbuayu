<?php

namespace App\Http\Controllers;

use App\Models\Paket;
use App\Models\Review;
use App\Models\Gallery; // Tambahkan ini jika kamu punya model Gallery
use Illuminate\Http\Request;
use Illuminate\Support\Collection;

class HomeController extends Controller
{
    public function index()
    {
        $packages = Paket::all();
        $reviews = Review::latest()->get();
        return view('welcome', compact('packages', 'reviews'));
    }

    /**
     * FUNGSI GALLERY YANG HILANG
     */
    public function gallery()
    {
        // 1. Ambil foto dari tabel Galleries (Jika ada)
        // Jika belum buat model/migration Gallery, abaikan baris ini atau buat dulu
        $manualGalleries = class_exists('\App\Models\Gallery') ? \App\Models\Gallery::all() : collect();

        // 2. Ambil foto dari tabel Reviews (Yang ada gambarnya)
        $reviewPhotos = Review::whereNotNull('image')->get()->map(function($item) {
            // Karena image di review berbentuk array, kita ambil index pertama
            $img = is_array($item->image) ? ($item->image[0] ?? null) : $item->image;
            return (object)[
                'title' => 'Review dari ' . $item->name,
                'image' => $img,
                'category' => 'customer'
            ];
        })->filter(fn($i) => !empty($i->image));

        // 3. Ambil foto dari tabel Pakets
        $paketPhotos = Paket::all()->map(function($item) {
            return (object)[
                'title' => $item->name,
                'image' => $item->image,
                'category' => 'Menu Paket'
            ];
        });

        // Gabungkan semua foto jadi satu koleksi
        $galleries = collect($manualGalleries)->merge($reviewPhotos)->merge($paketPhotos);

        return view('gallery', compact('galleries'));
    }

    public function location()
    {
        return view('location'); // Pastikan file location.blade.php ada
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
            'image' => $imagePaths,
        ]);

        return back()->with('success', 'Review berhasil dikirim!');
    }
}