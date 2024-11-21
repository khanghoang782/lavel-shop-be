<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Catalog extends Model
{
    /** @use HasFactory<\Database\Factories\CatalogFactory> */
    use HasFactory;

    protected $fillable = [
      'catalog_name',
    ];
    public function products():hasMany
    {
        return $this->hasMany(Product::class);
    }
}
