<?php

namespace App\Livewire;
use App\Models\Booking;

use Livewire\Component;

class BookingData extends Component
{
    public $transactions = [];

    public function render()
    {   
        $this->transactions = Booking::with([
            'customer:uuid,name,whatsapp_number,email',
            'service:uuid,name,price'
        ])
        ->select('customer_id', 'service_id', 'order_id', 'booking_code', 'booking_date', 'total_price', 'paid_amount', 'payment_status', 'payment_type', 'updated_at')
        ->get();
    return view('livewire.booking-data');
    }
}

