<?php

namespace App\Http\Controllers;

use App\Models\ProductDimension;
use App\Models\ProductImage;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\ProductTag;
use Illuminate\Support\Facades\Http;

class ProductController extends Controller
{
    public function fetchProductsFromApi()
    {
        $response = Http::withoutVerifying()->get('https://dummyjson.com/products');
            // env('DUMMY_API_URL');
        $products = $response->json()['products'];
        foreach ($products as $product) {
            Product::create([
                'title' => $product['title'],
                'description' => $product['description'],
                'price' => $product['price'],
                'category' => $product['category'],
                'discount_percentage' => $product['discountPercentage'],
                'rating' => $product['rating'],
                'stock' => $product['stock'],
                'brand' => isset($product['brand']) ? $product['brand'] : null,
                'weight' => $product['weight'],
                'thumbnail' => $product['thumbnail'],
            ]);
            foreach ($product['tags'] as $tag) {
                ProductTag::create([
                    'product_id' => $product['id'],
                    'name' => $tag
                ]);
            }
            $dimensions = $product['dimensions'];
            ProductDimension::create([
                'product_id' => $product['id'],
                'width' => $dimensions['width'],
                'height' => $dimensions['height'],
                'depth' => $dimensions['depth'],
            ]);
            foreach ($product['images'] as $image) {
                ProductImage::create([
                    'product_id' => $product['id'],
                    'image_path' => $image
                ]);
            }
            
        }
    }

    
}
