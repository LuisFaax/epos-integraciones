<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Delivery extends Model
{
    use HasFactory;

    protected $fillable = [
        'first_name',
        'last_name',
        'company',
        'address1',
        'address2',
        'city',
        'state',
        'postcode',
        'email',
        'phone',
        'country',
        'type'
    ];
}
