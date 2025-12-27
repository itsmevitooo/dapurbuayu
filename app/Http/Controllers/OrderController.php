<?php

namespace App\Http\Controllers;

use App\Models\Paket;
use App\Models\Order;
use App\Models\OrderItem;
use App\Services\MidtransService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class OrderController extends Controller
{
    /**
     * Menampilkan Form Detail Pesanan
     */
    public function showDetailForm($package_id)
    {
        $package = Paket::findOrFail($package_id);
        return view('orderdetail', compact('package'));
    }

    /**
     * Memproses data detail ke Session
     */
    public function processDetail(Request $request)
    {
        $package = Paket::findOrFail($request->package_id);
        
        // AMBIL LANGSUNG DARI DATABASE (Filament)
        // Gunakan ?? 1 sebagai pengaman jika data kosong
        $minQuantity = $package->min_order ?? 1;

        $minDate = Carbon::now()->addDays(2)->format('Y-m-d');

        $request->validate([
            'package_id' => 'required',
            'full_name' => 'required|string|max:255',
            'phone_number' => 'required|string',
            'address' => 'required|string',
            'delivery_date' => 'required|date|after_or_equal:' . $minDate,
            'quantity' => 'required|numeric|min:' . $minQuantity,
        ], [
            'delivery_date.after_or_equal' => 'Maaf, pemesanan minimal dilakukan 2 hari (H+2) dari hari ini.',
            'quantity.min' => 'Minimal pemesanan untuk paket ini adalah ' . $minQuantity . ' porsi.',
        ]);

        // Simpan ke session
        session(['order_data' => [
            'package_id' => $request->package_id,
            'package_name' => $package->name,
            'package_price' => $package->price,
            'full_name' => $request->full_name,
            'phone_number' => $request->phone_number,
            'address' => $request->address,
            'delivery_date' => $request->delivery_date,
            'quantity' => $request->quantity,
            'total_price' => $package->price * $request->quantity,
            'menu_selections' => json_encode($request->selections),
        ]]);

        return redirect()->route('order.show_payment');
    }

    /**
     * Menampilkan Halaman Pilihan Pembayaran
     */
    public function showPayment()
    {
        $orderData = session('order_data');

        if (!$orderData) {
            return redirect()->route('home')->with('error', 'Data pesanan tidak ditemukan.');
        }

        return view('payment', compact('orderData'));
    }

    /**
     * Proses Final: Simpan ke Database & Handle COD (WA) atau Transfer (Midtrans)
     * PERHATIAN: MidtransService dihapus dari parameter agar tidak otomatis memuat koneksi API.
     */
    public function processPayment(Request $request)
    {
        $orderData = session('order_data');
        if (!$orderData) {
            return response()->json(['error' => 'Data pesanan hilang.'], 400);
        }

        $paymentMethod = $request->input('payment_method');
        
        DB::beginTransaction();
        try {
            $invoiceCode = 'INV/' . date('YmdHis') . '/' . mt_rand(1000, 9999);
            $paymentDeadline = Carbon::parse($orderData['delivery_date'])->subDays(2)->endOfDay();

            // 1. Simpan Order ke Database (Proses Lokal - Sangat Cepat)
            $order = Order::create([
                'invoice_code' => $invoiceCode,
                'full_name' => $orderData['full_name'],
                'phone_number' => $orderData['phone_number'],
                'address' => $orderData['address'],
                'delivery_date' => $orderData['delivery_date'],
                'payment_deadline' => $paymentDeadline, 
                'total_price' => $orderData['total_price'],
                'payment_method' => $paymentMethod,
                'payment_status' => 'PENDING',
                'order_status' => 'DIPROSES'
            ]);

            OrderItem::create([
                'order_id' => $order->id,
                'item_name' => $orderData['package_name'],
                'quantity' => $orderData['quantity'],
                'price_per_item' => $orderData['package_price'],
                'side_dish' => $orderData['menu_selections'],
            ]);

            // --- ALUR: JIKA COD (INSTAN) ---
            if ($paymentMethod === 'COD') {
                DB::commit();
                session()->forget('order_data');

                $adminWa = env('CATERING_WA_NUMBER'); 
                
                $pesan = "Halo Dapur Bu Ayu, saya ingin konfirmasi pesanan dengan metode COD.\n\n"
                       . "*Nomor Invoice:* " . $invoiceCode . "\n"
                       . "*Nama:* " . $orderData['full_name'] . "\n"
                       . "*Total Bayar:* Rp " . number_format($orderData['total_price'], 0, ',', '.') . "\n"
                       . "*Tanggal Kirim:* " . date('d-m-Y', strtotime($orderData['delivery_date'])) . "\n\n"
                       . "Mohon segera dikonfirmasi ya, terima kasih!";

                return response()->json([
                    'status' => 'success',
                    'method' => 'COD',
                    'redirect_url' => "https://wa.me/" . $adminWa . "?text=" . urlencode($pesan)
                ]);
            }

            // --- ALUR: JIKA TRANSFER (Hanya memanggil Midtrans jika dibutuhkan) ---
            $midtransService = app(MidtransService::class); 
            $snapToken = $midtransService->createSnapToken($order);
            
            $order->update(['snap_token' => $snapToken]);

            DB::commit();
            session()->forget('order_data');

            return response()->json([
                'status' => 'success',
                'method' => 'TRANSFER',
                'snap_token' => $snapToken, 
                'invoice_code' => $invoiceCode
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['error' => 'Gagal: ' . $e->getMessage()], 500);
        }
    }

    public function success()
    {
        return view('ordersuccess');
    }
}