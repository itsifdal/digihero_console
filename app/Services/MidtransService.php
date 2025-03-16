<?php

namespace App\Services;

use Midtrans\Config;
use Midtrans\Snap;
use Midtrans\Notification;
use Exception;

class MidtransService
{
    public function __construct()
    {
        Config::$serverKey    = config('midtrans.server_key');
        Config::$isProduction = config('midtrans.is_production');
        Config::$isSanitized  = true;
        Config::$is3ds        = true;
    }

    public function createTransaction($orderId, $amount, $customerDetails)
    {
        $transaction = [
            'transaction_details' => [
                'order_id'     => $orderId,
                'gross_amount' => $amount,
            ],
            'customer_details' => [
                'first_name' => $customerDetails['name'],
                'phone'      => $customerDetails['whatsapp_number'],
                'email'      => $customerDetails['email']
            ]
        ];

        try {
            return Snap::getSnapToken($transaction);
        } catch (Exception $e) {
            return null;
        }
    }

    public function handleNotification()
    {
        $notif = new Notification();
        return [
            'order_id' => $notif->order_id,
            'status'   => $notif->transaction_status,
        ];
    }
}
