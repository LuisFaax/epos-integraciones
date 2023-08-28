<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sale extends Model
{
    use HasFactory;

    protected $fillable = [
        'total',
        'discount',
        'items',
        'status',
        'customer_id',
        'user_id',
    ];

    function details()
    {
        return $this->hasMany(SaleDetail::class);
    }

    function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    function user()
    {
        return $this->belongsTo(User::class);
    }
}
