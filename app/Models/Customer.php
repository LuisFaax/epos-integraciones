<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    use HasFactory;

    protected $fillable = [
        'first_name', 'last_name', 'email', 'phone', 'platform_id'
    ];


    public function deliveries()
    {
        return $this->belongsToMany(Delivery::class, 'customer_deliveries', 'customer_id', 'delivery_id');
    }
}
