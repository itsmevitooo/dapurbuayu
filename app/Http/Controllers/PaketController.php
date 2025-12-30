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
        // Ambil kategori dari URL, default ke 'nasi_box'
        $category = $request->query('category', 'nasi_box');

        // Mengambil data dari model Paket
        $pakets = Paket::where('category', $category)->get();

        // REVISI: Hapus '.index' karena file Mas namanya paket.blade.php
        return view('paket', compact('pakets', 'category'));
    }

    /**
     * Menampilkan detail paket
     */
    public function show($id)
    {
        $paket = Paket::findOrFail($id);

        // REVISI: Jika file detail Mas nanti namanya paket_detail.blade.php, ganti kesana.
        // Untuk sekarang saya asumsikan Mas akan buat file 'paket_detail.blade.php'
        return view('paket_detail', compact('paket'));
    }
}