<?php

namespace App\Http\Controllers;

use App\Models\Paket; // Menggunakan nama model Paket sesuai instruksi Anda
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class OrderController extends Controller
{
    public function showDetailForm($id)
    {
        // Mengambil data dari tabel products melalui model Paket
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

    public function processPayment(Request $request)
    {
        $orderData = session('order_data');
        if (!$orderData) {
            return response()->json(['error' => 'Sesi pesanan hilang'], 400);
        }

        DB::beginTransaction();
        try {
            $invoiceCode = 'INV/' . date('YmdHis') . '/' . mt_rand(1000, 9999);
            
            $deliveryDate = Carbon::parse($orderData['delivery_date']);
            $paymentDeadline = $deliveryDate->copy()->subDays(2)->endOfDay();

            // Insert ke tabel orders
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

            OrderItem::create([
                'order_id'       => $order->id,
                'product_id'     => $orderData['package_id'],
                'item_name'      => $orderData['package_name'],
                'quantity'       => $orderData['quantity'],
                'price_per_item' => $orderData['package_price'],
                'side_dish'      => json_encode($orderData['menu_selections']),
            ]);

            // Update total_orders di tabel products melalui model Paket
            Paket::where('id', $orderData['package_id'])->increment('total_orders');

            DB::commit();
            session()->forget('order_data');

            return response()->json(['status' => 'success', 'invoice' => $invoiceCode]);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}