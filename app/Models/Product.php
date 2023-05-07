<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'sku',
        'name',
        'description',
        'type',
        'status',
        'visibility',
        'price',
        'price2',
        'stock_status',
        'manage_stock',
        'stock_qty',
        'low_stock',
        'supplier_id',
        'platform_id'
    ];
}
