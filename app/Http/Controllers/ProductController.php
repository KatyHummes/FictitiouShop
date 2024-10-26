<?php

namespace App\Http\Controllers;

use App\Models\ProductDimension;
use App\Models\ProductFavorite;
use App\Models\ProductImage;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\ProductTag;
USE Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Inertia\Inertia;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::with('tags', 'favorites')->get();
        return Inertia::render('Dashboard', [
            'products' => $products
        ]);
    }

    public function product($id)
    {
        $product = Product::with('tags', 'images', 'reviews', 'dimensions')->find($id);
        return Inertia::render('Product', [
            'product' => $product
        ]);
    }
    
    public function show(){
        $userId = Auth::user()->id;
        $products = Product::with('tags', 'favorites')
        ->whereHas('favorites', function ($query) use ($userId) {
            $query->where('user_id', $userId);
        })
        ->get();

        return Inertia::render('Favorites', [
            'products' => $products
        ]);
    }

    public function favorites()
    {
        $userId = Auth::user()->id;
        $products = Product::with('tags', 'favorites')
        ->whereHas('favorites', function ($query) use ($userId) {
            $query->where('user_id', $userId);
        })
        ->get();

        return response()->json($products);
    }

    public function addFavorite(Request $request)
    {
        ProductFavorite::create([
            'product_id' => $request->input('product_id'),
            'user_id' => Auth::user()->id
        ]);
    }

    public function removeFavorite($id)
    {
        ProductFavorite::where('product_id', $id)
        ->where('user_id', Auth::user()->id)
        ->delete();
    }
}
