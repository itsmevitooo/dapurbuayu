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

    public function showDetailForm($id)
    {
        $package = Paket::findOrFail($id);
        $holidaysPath = storage_path('app/holidays.json');
        $tanggalLibur = file_exists($holidaysPath) ? json_decode(file_get_contents($holidaysPath), true) : [];
        if (!is_array($tanggalLibur)) $tanggalLibur = [];
        return view('orderdetail', compact('package', 'tanggalLibur'));
    }

    public function processDetail(Request $request)
    {
        $request->validate([
            'package_id'   => 'required|exists:paket,id', 
            'full_name'    => 'required|string|max:255',
            'phone_number' => 'required|string|max:20',
            'address'      => 'required|string',
            'delivery_date'=> 'required', 
            'quantity'     => 'required|integer|min:1',
        ]);
    
        $holidaysPath = storage_path('app/holidays.json');
        $tanggalLibur = file_exists($holidaysPath) ? json_decode(file_get_contents($holidaysPath), true) : [];
        
        try {
            $inputDate = Carbon::parse($request->delivery_date);
            $fullDateTime = $inputDate->format('Y-m-d H:i:s');
            $dateOnly = $inputDate->format('Y-m-d');
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['delivery_date' => 'Format tidak valid.']);
        }
    
        if (in_array($dateOnly, (array)$tanggalLibur)) {
            return redirect()->back()->withErrors(['delivery_date' => 'Maaf, tanggal tersebut libur.']);
        }
    
        $package = Paket::findOrFail($request->package_id);
        $selections = $request->input('selections', []);
    
        session(['order_data' => [
            'package_id'      => $package->id,
            'package_name'    => $package->name,
            'package_price'   => $package->price,
            'full_name'       => $request->full_name,
            'phone_number'    => $request->phone_number,
            'address'         => $request->address,
            'delivery_date'   => $fullDateTime, 
            'quantity'        => $request->quantity,
            'total_price'     => $package->price * $request->quantity,
            'menu_selections' => is_array($selections) ? array_values($selections) : [$selections],
        ]]);
    
        return redirect()->route('order.payment');
    }

    public function processPayment(Request $request)
    {
        $orderData = session('order_data');
        if (!$orderData) return response()->json(['error' => 'Sesi hilang'], 400);

        DB::beginTransaction();
        try {
            $invoiceCode = 'INV-' . date('YmdHis') . '-' . mt_rand(100, 999);
            // Menghitung H-2 dari delivery date sebagai batas waktu bayar
            $deadline = Carbon::parse($orderData['delivery_date'])->subDays(2)->endOfDay();
            
            $order = Order::create([
                'invoice_code'     => $invoiceCode,
                'full_name'        => $orderData['full_name'],
                'phone_number'     => $orderData['phone_number'],
                'total_price'      => $orderData['total_price'],
                'payment_method'   => $request->payment_method,
                'address'          => $orderData['address'],
                'delivery_date'    => $orderData['delivery_date'],
                'payment_deadline' => $deadline, // DEADLINE DISIMPAN
                'payment_status'   => 'PENDING',
                'order_status'     => 'DIPROSES',
            ]);

            OrderItem::create([
                'order_id'  => $order->id,
                'paket_id'  => $orderData['package_id'],
                'item_name' => $orderData['package_name'], 
                'quantity'  => $orderData['quantity'],
                'price'     => $orderData['package_price'],
                'subtotal'  => $orderData['total_price'],
                'side_dish' => $orderData['menu_selections'] ?? [], 
            ]);

            Paket::where('id', $orderData['package_id'])->increment('total_orders');

            $params = [
                'transaction_details' => ['order_id' => $invoiceCode, 'gross_amount' => (int) $orderData['total_price']],
                'customer_details' => ['first_name' => $orderData['full_name'], 'phone' => $orderData['phone_number']],
            ];

            $snapToken = Snap::getSnapToken($params);
            $order->update(['snap_token' => $snapToken]);

            DB::commit();
            return response()->json(['snap_token' => $snapToken, 'invoice_code' => $invoiceCode]);

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