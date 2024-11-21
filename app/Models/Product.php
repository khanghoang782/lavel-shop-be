<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Product extends Model
{
    /** @use HasFactory<\Database\Factories\ProductFactory> */
    use HasFactory;
    protected $fillable = [
        'product_name',
        'description',
        'price',
        'stock',
        'catalog_id',
    ];
    public function catalog():BelongsTo
    {
        return $this->belongsTo(Catalog::class);
    }
}
