<?php
// app/Http/Controllers/MidtransController.php
namespace App\Http\Controllers;

use App\Models\Order;
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

        $order = Order::where('invoice_code', $orderId)->first();

        if (!$order) {
            return response()->json(['message' => 'Order not found'], 404);
        }

        if ($transactionStatus == 'capture') {
            if ($fraudStatus == 'accept') {
                $order->payment_status = 'PAID';
                $order->order_status = 'MENUNGGU PERSIAPAN'; // Dianggap diterima admin
            }
        } elseif ($transactionStatus == 'settlement') {
            $order->payment_status = 'PAID';
            $order->order_status = 'MENUNGGU PERSIAPAN';
        } elseif ($transactionStatus == 'pending') {
            $order->payment_status = 'PENDING';
        } elseif ($transactionStatus == 'deny' || $transactionStatus == 'expire' || $transactionStatus == 'cancel') {
            $order->payment_status = 'CANCELLED';
            $order->order_status = 'DITOLAK';
        }

        $order->save();

        return response()->json(['message' => 'Notification processed successfully']);
    }
}