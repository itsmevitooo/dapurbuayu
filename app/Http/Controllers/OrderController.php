<?php

namespace App\Http\Controllers;

use App\Models\Paket; 
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class OrderController extends Controller
{
    public function showDetailForm($id)
    {
        $package = Paket::findOrFail($id);
        return view('orderdetail', compact('package'));
    }

    public function processDetail(Request $request)
    {
        $request->validate([
            'package_id'   => 'required|exists:products,id',
            'full_name'    => 'required|string|max:255',
            'phone_number' => 'required|string|max:20',
            'address'      => 'required|string',
            'delivery_date'=> 'required|date',
            'quantity'     => 'required|integer',
        ]);

        $package = Paket::findOrFail($request->package_id);
        
        session(['order_data' => [
            'package_id'      => $package->id,
            'package_name'    => $package->name,
            'package_price'   => $package->price,
            'full_name'       => $request->full_name,
            'phone_number'    => $request->phone_number,
            'address'         => $request->address,
            'delivery_date'   => $request->delivery_date,
            'quantity'        => $request->quantity,
            'total_price'     => $package->price * $request->quantity,
            'menu_selections' => $request->selections, 
        ]]);

        return redirect()->route('order.payment');
    }

    public function showPayment()
    {
        $orderData = session('order_data');
        if (!$orderData) {
            return redirect()->route('home')->with('error', 'Sesi pesanan hilang.');
        }
        return view('payment', compact('orderData'));
    }

    public function processPayment(Request $request)
    {
        $orderData = session('order_data');
        if (!$orderData) {
            return response()->json(['error' => 'Sesi pesanan hilang'], 400);
        }

        DB::beginTransaction();
        try {
            $invoiceCode = 'INV-' . date('YmdHis') . '-' . mt_rand(100, 999);
            $deliveryDate = Carbon::parse($orderData['delivery_date']);
            
            // Catatan: Pastikan kolom payment_deadline sudah ada di tabel orders Anda
            $paymentDeadline = $deliveryDate->copy()->subDays(2)->endOfDay();

            // 1. Simpan ke Tabel Orders
            $order = Order::create([
                'invoice_code'     => $invoiceCode,
                'full_name'        => $orderData['full_name'],
                'phone_number'     => $orderData['phone_number'],
                'total_price'      => $orderData['total_price'],
                'payment_method'   => $request->payment_method,
                'address'          => $orderData['address'],
                'delivery_date'    => $orderData['delivery_date'],
                'payment_deadline' => $paymentDeadline,
                'payment_status'   => 'PENDING',
                'order_status'     => 'DIPROSES',
            ]);

            // 2. Simpan ke Tabel OrderItems (Disesuaikan dengan image_49866c.jpg)
            OrderItem::create([
                'order_id'  => $order->id,
                'paket_id'  => $orderData['package_id'], // Sesuai kolom database
                'quantity'  => $orderData['quantity'],
                'price'     => $orderData['package_price'], // Sesuai kolom database
                'subtotal'  => $orderData['total_price'],   // Sesuai kolom database
            ]);

            // 3. Update total order di tabel products
            Paket::where('id', $orderData['package_id'])->increment('total_orders');

            DB::commit();

            if ($request->payment_method === 'COD') {
                $whatsappUrl = "https://wa.me/628123456789?text=" . urlencode(
                    "Halo Dapur Bu Ayu, saya ingin konfirmasi pesanan COD.\n\n" .
                    "Invoice: " . $invoiceCode . "\n" .
                    "Nama: " . $orderData['full_name'] . "\n" .
                    "Paket: " . $orderData['package_name'] . "\n" .
                    "Total: Rp " . number_format($orderData['total_price'], 0, ',', '.')
                );
                
                session()->forget('order_data');
                return response()->json([
                    'method' => 'COD',
                    'invoice_code' => $invoiceCode,
                    'redirect_url' => $whatsappUrl
                ]);
            } else {
                return response()->json([
                    'method' => 'MIDTRANS',
                    'snap_token' => 'YOUR_SNAP_TOKEN_HERE', 
                    'invoice_code' => $invoiceCode
                ]);
            }

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function success()
    {
        return view('paymentsuccess');
    }
}