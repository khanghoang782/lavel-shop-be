<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HasAttribute extends Model
{
    //
    use HasFactory;

    protected $fillable = ['product_id','attribute_id'];
}
