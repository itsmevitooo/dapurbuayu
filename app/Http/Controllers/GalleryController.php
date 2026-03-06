<?php

namespace App\Http\Controllers;

use App\Models\Gallery;
use App\Models\Review;
use Illuminate\Http\Request;

class GalleryController extends Controller
{
    public function index()
    {
        // 1. Ambil data galeri dari admin
        $adminGalleries = Gallery::all();

        // 2. Ambil review yang PUNYA GAMBAR saja
        $customerReviews = Review::whereNotNull('image')
            ->get()
            ->flatMap(function ($review) {
                // Pastikan image adalah array dan tidak kosong
                $images = is_array($review->image) ? $review->image : [];
                
                // Jika array kosong (misal simpanan lama berupa []), abaikan
                if (empty($images)) {
                    return [];
                }

                return collect($images)->map(function ($img) use ($review) {
                    return (object) [
                        'title' => 'Review dari ' . $review->name,
                        'image' => $img,
                        'category' => 'customer',
                        'description' => $review->comment
                    ];
                });
            });

        // 3. Gabungkan galeri admin dengan foto review pelanggan
        $galleries = $adminGalleries->concat($customerReviews);

        return view('gallery', compact('galleries'));
    }
}