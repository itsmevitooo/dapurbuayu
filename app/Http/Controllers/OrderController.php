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
use Midtrans\Notification;

class OrderController extends Controller
{
    public function __construct()
    {
        Config::$serverKey = config('services.midtrans.server_key');
        Config::$isProduction = config('services.midtrans.is_production');
        Config::$isSanitized = true;
        Config::$is3ds = true;
    }

    // 1. Ambil data tanggal libur dari holidays.json dan kirim ke View Detail/Form Order
    public function showDetailForm($id)
    {
        $package = Paket::findOrFail($id);
        
        // FIX: Membaca langsung file holidays.json hasil simpanan Filament Page kamu
        $holidaysPath = storage_path('app/holidays.json');
        $tanggalLibur = file_exists($holidaysPath) ? json_decode(file_get_contents($holidaysPath), true) : [];

        // Memastikan output berupa array bersih
        if (!is_array($tanggalLibur)) {
            $tanggalLibur = [];
        }

        // Kirim variabel $tanggalLibur langsung ke view
        return view('orderdetail', compact('package', 'tanggalLibur'));
    }

    // 2. Validasi sisi backend mendeteksi kecocokan tanggal di holidays.json
    public function processDetail(Request $request)
    {
        $request->validate([
            'package_id'   => 'required|exists:paket,id', 
            'full_name'    => 'required|string|max:255',
            'phone_number' => 'required|string|max:20',
            'address'      => 'required|string',
            'delivery_date'=> 'required|date',
            'quantity'     => 'required|integer|min:1',
        ]);

        // FIX: Ambil validasi pembanding dari file holidays.json di Back-end
        $holidaysPath = storage_path('app/holidays.json');
        $tanggalLibur = file_exists($holidaysPath) ? json_decode(file_get_contents($holidaysPath), true) : [];
        
        if (!is_array($tanggalLibur)) {
            $tanggalLibur = [];
        }

        try {
            $inputDeliveryDate = Carbon::parse($request->delivery_date)->format('Y-m-d');
        } catch (\Exception $e) {
            return redirect()->back()
                ->withInput()
                ->withErrors(['delivery_date' => 'Format tanggal tidak valid.']);
        }

        if (in_array($inputDeliveryDate, $tanggalLibur)) {
            return redirect()->back()
                ->withInput()
                ->withErrors(['delivery_date' => 'Maaf, tanggal yang Anda pilih adalah hari libur atau slot catering kami sudah penuh.']);
        }

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
            'delivery_date'   => $inputDeliveryDate, 
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
                'side_dish' => $orderData['menu_selections'] ?? [], 
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
                'redirect_url' => $isCOD ? "https://wa.me/628123456789?text=Halo Admin, saya memesan paket katering {$orderData['package_name']} dengan Invoice: {$invoiceCode}" : ""
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function callback()
    {
        try {
            $notification = new Notification();
            $orderId = $notification->order_id;
            $transactionStatus = $notification->transaction_status;

            $order = Order::where('invoice_code', $orderId)->first();

            if ($order) {
                if ($transactionStatus == 'capture' || $transactionStatus == 'settlement') {
                    $order->update(['payment_status' => 'LUNAS']);
                } else if ($transactionStatus == 'cancel' || $transactionStatus == 'deny' || $transactionStatus == 'expire') {
                    $order->update(['payment_status' => 'EXPIRED']);
                } else if ($transactionStatus == 'pending') {
                    $order->update(['payment_status' => 'PENDING']);
                }
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