<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Customer extends Model
{
    use HasFactory;
    
    protected $primaryKey = 'uuid'; 
    public $incrementing  = false;  
    protected $keyType    = 'string'; 
    public $timestamps    = false;

    
    protected $fillable = [
        'name',
        'whatsapp_number', 
        'email'
    ];

    protected $nullable = [
        'email'
    ];

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($customer) {
            $customer->uuid = Str::uuid()->toString();
        });
    }
}
