<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductFeedback extends Model
{
    /** @use HasFactory<\Database\Factories\ProductFeedbackFactory> */
    use HasFactory;
    protected $fillable=[
        'of_product',
        'created_by',
        'rating',
        'feedback',
    ];
}
