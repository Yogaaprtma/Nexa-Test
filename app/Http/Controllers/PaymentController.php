<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Payment;
use App\Models\Order;
use Illuminate\Support\Facades\Auth;

class PaymentController extends Controller
{
    // Formulir pembayaran
    public function showPaymentForm($order_id)
    {
        $order = Order::with('orderItems')->findOrFail($order_id);
        return view('customer.order.payment', compact('order'));
    }

    // Proses pembayaran
    public function processPayment(Request $request)
    {
        $request->validate([
            'order_id' => 'required|exists:orders,id',
            'payment_method' => 'required|in:bank_transfer,e_wallet,credit_card,cash',
            'amount' => 'required|numeric|min:1'
        ]);

        $order = Order::findOrFail($request->order_id);

        // Cek apakah total pembayaran sesuai dengan total order
        $totalAmount = $order->orderItems->sum(function($item) {
            return $item->harga * $item->jumlah;
        });

        if ($request->amount < $totalAmount) {
            return redirect()->back()->with('error', 'Jumlah pembayaran tidak sesuai!');
        }

        // Update status order ke completed
        $order->update(['status' => 'completed']);

        // Catat pembayaran
        Payment::create([
            'order_id' => $order->id,
            'payment_method' => $request->payment_method,
            'amount' => $totalAmount,
            'paid_at' => now()
        ]);

        return redirect()->route('customer.history')->with('success', 'Pembayaran berhasil dilakukan!');
    }
}