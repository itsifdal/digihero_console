<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Booking extends Model
{
    use HasFactory;

    protected $primaryKey = 'uuid'; 
    public $incrementing  = false;  
    protected $keyType    = 'string'; 

    protected $fillable = [
        'customer_id',
        'service_id',
        'order_id',
        'booking_code',
        'booking_date',
        'total_price',
        'paid_amount',
        'payment_status',
        'payment_type',
        'signature_key',
    ];

    protected $nullable = [
        'paid_amount',
        'payment_status',
        'payment_type',
        'descsignature_keyription'
    ];

    protected $cast = [
        'booking_date' => 'datetime', 
        'total_price'  => 'decimal:10,2',
        'paid_amount'  => 'decimal:10,2'
    ];

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($booking) {
            $booking->uuid = Str::uuid()->toString();
        });
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class, 'customer_id', 'uuid');
    }

    public function service()
    {
        return $this->belongsTo(Service::class, 'service_id', 'uuid');
    }
}
