<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;

class CheckOrderController extends Controller
{
    public function index()
    {
        return view('check_order');
    }

    public function search(Request $request)
    {
        $request->validate([
            'invoice_code' => 'required|string',
        ]);

        // REVISI: Tambahkan 'items.product' agar data produk ikut terbawa
        $order = Order::with('items.product')->where('invoice_code', $request->invoice_code)->first();

        if (!$order) {
            return redirect()->route('check_order.index')->with('error', 'Kode Invoice tidak ditemukan.');
        }

        return view('check_order', compact('order'));
    }
}