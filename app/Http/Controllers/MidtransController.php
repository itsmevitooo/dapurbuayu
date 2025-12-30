<?php
// app/Http/Controllers/MidtransController.php
namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Product; // Pastikan Modelnya bernama Product
use Illuminate\Http\Request;
use Midtrans\Notification;

class MidtransController extends Controller
{
    public function notificationHandler(Request $request)
    {
        $notification = new Notification();
        $orderId = $notification->order_id;
        $transactionStatus = $notification->transaction_status;
        $fraudStatus = $notification->fraud_status;

        $order = Order::with('items')->where('invoice_code', $orderId)->first();

        if (!$order) {
            return response()->json(['message' => 'Order not found'], 404);
        }

        $isPaidNow = false;

        if ($transactionStatus == 'capture') {
            if ($fraudStatus == 'accept') {
                if ($order->payment_status !== 'PAID') $isPaidNow = true;
                $order->payment_status = 'PAID';
                $order->order_status = 'MENUNGGU PERSIAPAN';
            }
        } elseif ($transactionStatus == 'settlement') {
            if ($order->payment_status !== 'PAID') $isPaidNow = true;
            $order->payment_status = 'PAID';
            $order->order_status = 'MENUNGGU PERSIAPAN';
        } elseif ($transactionStatus == 'pending') {
            $order->payment_status = 'PENDING';
        } elseif ($transactionStatus == 'deny' || $transactionStatus == 'expire' || $transactionStatus == 'cancel') {
            $order->payment_status = 'CANCELLED';
            $order->order_status = 'DITOLAK';
        }

        $order->save();

        // LOGIKA BEST SELLER: Update ke tabel products
        if ($isPaidNow) {
            foreach ($order->items as $item) {
                // Gunakan Model Product dan kolom total_orders
                Product::where('id', $item->paket_id)
                    ->increment('total_orders', $item->quantity);
            }
        }

        return response()->json(['message' => 'Notification processed successfully']);
    }
}