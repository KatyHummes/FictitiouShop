<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use SoftDeletes;
    protected $fillable = [
        'title',
        'description',
        'price',
        'category',
        'discount_percentage',
        'rating',
        'stock',
        'brand',
        'weight',
        'reviews',
        'dimensions',
        'images',
        'thumbnail',
    ];

    public function tags()
    {
        return $this->hasMany(ProductTag::class);
    }

    public function dimensions()
    {
        return $this->hasOne(ProductDimension::class);
    }

    public function images()
    {
        return $this->hasMany(ProductImage::class);
    }

    public function reviews()
    {
        return $this->hasMany(ProductReview::class);
    }

    public function favorites()
    {
        return $this->hasMany(ProductFavorite::class);
    }
}
