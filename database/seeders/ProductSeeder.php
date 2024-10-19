<?php

namespace Database\Seeders;

use App\Models\ProductReview;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\ProductDimension;
use App\Models\ProductImage;
use App\Models\Product;
use App\Models\ProductTag;
use Illuminate\Support\Facades\Http;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $response = Http::withoutVerifying()->get('https://dummyjson.com/products');
        $products = $response->json()['products'];
        // dd('produtos', $products);
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
            foreach ($product['reviews'] as $review) {
                ProductReview::create([
                    'product_id' => $product['id'],
                    'reviewer_name' => $review['reviewerName'],
                    'reviewer_email' => $review['reviewerEmail'],
                    'rating' => $review['rating'],
                    'comment' => $review['comment'],
                ]);
            }
        }
    }
}
