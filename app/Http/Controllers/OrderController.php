<?php

namespace App\Http\Controllers;

use App\Models\Paket; 
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;
use Midtrans\Config;
use Midtrans\Snap;
use Midtrans\Notification; // Tambahkan ini

class OrderController extends Controller
{
    public function __construct()
    {
        Config::$serverKey = config('services.midtrans.server_key');
        Config::$isProduction = config('services.midtrans.is_production');
        Config::$isSanitized = true;
        Config::$is3ds = true;
    }

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
            'quantity'     => 'required|integer|min:1',
        ]);

        $package = Paket::findOrFail($request->package_id);
        $selections = $request->input('selections', []);
        $menuArray = is_array($selections) ? array_values($selections) : [$selections];

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
            'menu_selections' => $menuArray,
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
            $paymentDeadline = $deliveryDate->copy()->subDays(2)->endOfDay();
            $totalHarga = (int) $orderData['total_price'];

            $isCOD = ($request->payment_method === 'COD');
            $nominalBayarMidtrans = $isCOD ? ($totalHarga * 0.5) : $totalHarga;

            $order = Order::create([
                'invoice_code'     => $invoiceCode,
                'full_name'        => $orderData['full_name'],
                'phone_number'     => $orderData['phone_number'],
                'total_price'      => $totalHarga, 
                'payment_method'   => $request->payment_method,
                'address'          => $orderData['address'],
                'delivery_date'    => $orderData['delivery_date'],
                'payment_deadline' => $paymentDeadline,
                'payment_status'   => 'PENDING',
                'order_status'     => 'DIPROSES',
            ]);

            OrderItem::create([
                'order_id'  => $order->id,
                'paket_id'  => $orderData['package_id'],
                'item_name' => $orderData['package_name'], 
                'quantity'  => $orderData['quantity'],
                'price'     => $orderData['package_price'],
                'subtotal'  => $totalHarga,
                'side_dish' => implode(', ', $orderData['menu_selections'] ?? []),
            ]);

            Paket::where('id', $orderData['package_id'])->increment('total_orders');

            $params = [
                'transaction_details' => [
                    'order_id' => $invoiceCode,
                    'gross_amount' => (int) $nominalBayarMidtrans, 
                ],
                'customer_details' => [
                    'first_name' => $orderData['full_name'],
                    'phone' => $orderData['phone_number'],
                ],
            ];

            $snapToken = Snap::getSnapToken($params);
            $order->update(['snap_token' => $snapToken]);

            DB::commit();

            return response()->json([
                'method' => $request->payment_method,
                'snap_token' => $snapToken,
                'invoice_code' => $invoiceCode,
                'redirect_url' => $isCOD ? "https://wa.me/628123456789?text=Konfirmasi..." : ""
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    /**
     * CALLBACK VERSI ANTI-GAGAL: STATUS JADI LUNAS
     */
    public function callback()
    {
        try {
            $notification = new Notification();
            $orderId = $notification->order_id;
            $transactionStatus = $notification->transaction_status;
            $fraudStatus = $notification->fraud_status;

            Log::info("Callback Midtrans Diterima untuk Order: " . $orderId);

            $order = Order::where('invoice_code', $orderId)->first();

            if ($order) {
                if ($transactionStatus == 'capture') {
                    if ($fraudStatus == 'challenge') {
                        $order->update(['payment_status' => 'PENDING']);
                    } else if ($fraudStatus == 'accept') {
                        $order->update(['payment_status' => 'LUNAS']);
                    }
                } else if ($transactionStatus == 'settlement') {
                    $order->update(['payment_status' => 'LUNAS']);
                } else if ($transactionStatus == 'cancel' || $transactionStatus == 'deny' || $transactionStatus == 'expire') {
                    $order->update(['payment_status' => 'EXPIRED']);
                } else if ($transactionStatus == 'pending') {
                    $order->update(['payment_status' => 'PENDING']);
                }

                Log::info("Status Order {$orderId} sekarang: " . $order->payment_status);
                return response()->json(['status' => 'OK']);
            }
        } catch (\Exception $e) {
            Log::error("Error Callback: " . $e->getMessage());
            return response()->json(['status' => 'Error'], 500);
        }
    }

    public function success()
    {
        session()->forget('order_data');
        return view('paymentsuccess');
    }
}