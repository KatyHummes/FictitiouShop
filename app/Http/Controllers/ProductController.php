<?php

namespace App\Http\Controllers;

use App\Models\ProductDimension;
use App\Models\ProductImage;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\ProductTag;
use Illuminate\Support\Facades\Http;
use Inertia\Inertia;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::with('tags', 'images', 'dimensions')->get();
        return Inertia::render('Dashboard', [
            'products' => $products
        ]);
    }
}
