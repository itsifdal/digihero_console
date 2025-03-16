<?php

namespace App\Http\Controllers;
use App\Models\Booking;

use Illuminate\Http\Request;

class BookingController extends Controller
{
    public function callback(Request $request)
    {
        $order_id           = $request->order_id;
        $transaction_status = $request->transaction_status;
        $signature_key      = $request->signature_key;
        $gross_amount       = $request->gross_amount;
        $payment_type       = $request->payment_type;
        $fraudStatus        = $request->fraudStatus;

        if ($transaction_status == 'capture'){
            if ($fraudStatus == 'accept'){
                    $transaction_status = 'settlement';
                    $paid_amount = $gross_amount;
            }
        } else if ($transaction_status == 'settlement'){
            $transaction_status = 'settlement';
            $paid_amount = $gross_amount;
        } else if ($transaction_status == 'cancel' || $transaction_status == 'deny' || $transaction_status == 'expire'){
            $transaction_status = 'failure';
            $paid_amount = '0';
        } else if ($transaction_status == 'pending'){
            $transaction_status = 'pending';
            $paid_amount = '0';
        }

        // Cari transaksi berdasarkan order_id
        $transaction = Booking::where('order_id', $order_id)->first();

        if (!$transaction) {
            return response()->json(['message' => 'Transaction not found'], 404);
        }

        // Update Transaction Status
        $transaction->update([
            'payment_status'     => $transaction_status,
            'status_code'        => $status_code,
            'signature_key'      => $signature_key,
            'paid_amount'        => $paid_amount,
            'payment_type'       => $payment_type
        ]);

    }
}
