<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductDimension extends Model
{
    protected $fillable = [
        'product_id',
        'depth',
        'width',
        'height',
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
