<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Paket;

class PaketController extends Controller
{
    /**
     * Menampilkan daftar paket berdasarkan kategori
     */
    public function index(Request $request)
    {
        // Default category adalah nasi_box jika tidak ada input
        $category = $request->query('category', 'nasi_box');
        
        // Ambil paket beserta details-nya agar tidak error di blade
        $pakets = Paket::with('details')->where('category', $category)->get();
    
        return view('paket', compact('pakets', 'category'));
    }
    
    /**
     * Menampilkan detail satu paket
     * Fungsi ini cuma boleh ada SATU di sini
     */
    public function show($id)
    {
        // Ambil data paket beserta detail isian menunya
        $paket = Paket::with('details')->findOrFail($id);
        
        return view('paket_detail', compact('paket'));
    }
}