<?php

namespace App\Livewire\Forms;

use Livewire\Component;
use Illuminate\Support\Str;
use App\Models\Service;
use App\Models\Customer;
use App\Models\Booking;
use App\Services\MidtransService;
use Carbon\Carbon;

use Livewire\Attributes\Validate;
use Illuminate\Support\Facades\DB;

class BookingForm extends Component
{   
    // Step
    public $step = 1;

    // Service
    public $services;
    public $weekendCharge = 50000;
    public $isCharged = false;
    public $normal_price;

    // Customer
    public $customer_name, $whatsapp_number, $email;

    // Booking
    public $customer_id, $service_id, $booking_code, $total_price;

    // Transaction
    public $snapToken;
    public $orderId;

    // Calendar
    public $selectedDate;

    protected $listeners = ['dateClicked' => 'handleDateClicked'];

    public function mount()
    {   
        $this->services = Service::all();
    }
    public function render()
    {
        return view('livewire.forms.booking-form');
    }

    public function selectServiceId($service_id)
    {   
        $this->service_id = $service_id;
    }

    public function handleDateClicked($date)
    {
        $carbonDate = Carbon::parse($date);
        $this->selectedDate = $carbonDate->format('Y-m-d');

        if ($carbonDate->isWeekend()) {

            $isCharged = true;
            session()->flash('message', 'Tanggal yang dipilih adalah weekend, Charge Rp50.000 berlaku 🎉');
        }
    }

    public function calculatePrice(){

        // Get Service Normal Price
        $service    = Service::find($this->service_id);
        $this->normal_price = $service->price;
        $price      = $service->price;

        // Check if date is weekend
        $date       = $this->selectedDate;
        $carbonDate = Carbon::parse($date);

        if ($carbonDate->isWeekend()) {
            $price += $this->weekendCharge;
        }

        $this->total_price = $price;
    }

    public function processPayment(MidtransService $midtransService)
    {
        // Validate
        $this->validate([
            'customer_name'       => ['required', 'string', 'max:50'],
            'whatsapp_number'     => ['required', 'numeric', 'digits_between:11,14']
        ]);

        try {
            DB::beginTransaction();

            // **Simpan Data Customer**
            $customerDetails = [
                'name'            => $this->customer_name,
                'whatsapp_number' => $this->whatsapp_number,
                'email'           => $this->email
            ];

            // dd($customerDetails);

            $customer = Customer::create($customerDetails);
            $this->customer_id = $customer->uuid;

            // **Generate Order ID**
            $this->orderId      = 'DHC-ORDER-ID-' . uniqid();
            $this->booking_code = 'DHC-' . Str::random(9);

            // **Simpan Data Booking**
            $bookingDetails = [
                'customer_id'        => $this->customer_id,
                'service_id'         => $this->service_id,
                'order_id'           => $this->orderId,
                'booking_code'       => $this->booking_code,
                'booking_date'       => $this->selectedDate,
                'total_price'        => $this->total_price,
                'payment_status'     => 'Tertunda',
            ];

            // **Save Booking**
            Booking::create($bookingDetails);

            // **Get Snap Token**
            $this->snapToken = $midtransService->createTransaction($this->orderId, $this->total_price, $customerDetails);

            // **dispatch midtransTokenGenerated **
            $this->dispatch('midtransTokenGenerated', $this->snapToken);

            DB::commit(); // Commit transaction
            session()->flash('success', 'Data berhasil disimpan!');
        } catch (\Exception $e) {
            DB::rollBack(); // Roolback if fail
            session()->flash('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function nextStep(){
        $this->step++;
        if ($this->step == 2) {
            $this->calculatePrice();
        }
    }

    public function prevStep(){
        $this->step--;
    }
}

