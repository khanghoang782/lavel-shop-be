<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderDetail extends Model
{
    protected $fillable = [
        'order_id',
        'created_by',
        'product_id',
        'type',
        'quantity'
    ];
}
