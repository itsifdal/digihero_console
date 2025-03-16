<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Service extends Model
{
    use HasFactory;

    protected $primaryKey = 'uuid'; 
    public $incrementing  = false;  
    protected $keyType    = 'string';
    public $timestamps    = false;
    
    protected $fillable = [
        'name',
        'price',
    ];

    protected $cast = [
        'price'  => 'decimal:10,2',
    ];

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($service) {
            $service->uuid = Str::uuid()->toString();
        });
    }
}
