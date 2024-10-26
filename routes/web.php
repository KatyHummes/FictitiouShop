<?php

use App\Http\Controllers\ProductController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/welcome', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register')
    ]);
});

Route::get('/', [ProductController::class, 'index'])->name('dashboard');
Route::get('/product/{id}', [ProductController::class, 'product'])->name('product');

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/show', [ProductController::class, 'show'])->name('favorite.show');
    Route::get('/favorites', [ProductController::class, 'favorites'])->name('favorites');
    Route::post('/favorites', [ProductController::class, 'addFavorite'])->name('favorites.add');
    Route::delete('/favorites/{id}', [ProductController::class, 'removeFavorite'])->name('favorites.remove');
});
