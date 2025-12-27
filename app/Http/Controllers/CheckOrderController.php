<?php
// app/Http/Controllers/CheckOrderController.php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;

class CheckOrderController extends Controller
{
    /**
     * Menampilkan halaman form cek order.
     */
    public function index()
    {
        // Tampilkan halaman cek order tanpa data awal
        return view('check_order');
    }

    /**
     * Mencari order berdasarkan kode invoice.
     */
    public function search(Request $request)
    {
        // Validasi input
        $request->validate([
            'invoice_code' => 'required|string',
        ]);

        // Cari order berdasarkan kode invoice dan sertakan itemnya
        $order = Order::with('items')->where('invoice_code', $request->invoice_code)->first();

        if (!$order) {
            return redirect()->route('check_order.index')->with('error', 'Kode Invoice tidak ditemukan.');
        }

        // Tampilkan hasil di view check_order
        return view('check_order', compact('order'));
    }
}