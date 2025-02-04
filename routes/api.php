<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\Api\CartController;
use App\Http\Controllers\Api\WishlistController;
use App\Http\Controllers\Api\OrderController;
use App\Http\Controllers\Api\ProfileController;
use App\Http\Controllers\Api\ImageController;

// Public API routes
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

// Public Product routes
Route::get('/products', [ProductController::class, 'index']);
Route::get('/products/{id}', [ProductController::class, 'show']);

// Public Product Image Routes
Route::get('/images/products/{filename}', [ImageController::class, 'showProductImage']);

// Public Product Gallery Image Routes
Route::get('/images/product_galleries/{filename}', [ImageController::class, 'showGalleryImage']);

// Protected API routes
Route::middleware('auth:api')->group(function () {
    // Auth routes
    Route::get('/user', [AuthController::class, 'user']);
    Route::get('/dashboard', [AuthController::class, 'dashboard']);
    Route::post('/logout', [AuthController::class, 'logout']);

    // Profile routes
    Route::prefix('profile')->group(function () {
        Route::get('/', [ProfileController::class, 'show']);
        Route::put('/', [ProfileController::class, 'update']);
        Route::put('/password', [ProfileController::class, 'updatePassword']);
        Route::get('/orders', [ProfileController::class, 'orders']);
    });

    // Cart routes
    Route::prefix('cart')->group(function () {
        Route::get('/', [CartController::class, 'index']);  // View cart items
        Route::post('/', [CartController::class, 'store']);  // Add product to cart
        Route::put('/{id}', [CartController::class, 'update']);  // Update cart item
        Route::delete('/{id}', [CartController::class, 'destroy']);  // Remove item from cart
        Route::delete('/', [CartController::class, 'clear']);  // Clear cart
        Route::post('/buy-now', [CartController::class, 'buyNow']); // Add product for checkout (buy now)
    });

    // Wishlist routes
// Fetch Wishlist for authenticated user
Route::get('/wishlist', [WishlistController::class, 'index']);

// Add or Remove product from wishlist (Toggle)
Route::post('/wishlist/toggle', [WishlistController::class, 'toggle']);

// Check if product is in wishlist
Route::get('/wishlist/check/{productId}', [WishlistController::class, 'check']);

    // Order routes
    Route::prefix('orders')->group(function () {
        Route::get('/', [OrderController::class, 'index']);
        Route::post('/', [OrderController::class, 'store']);
        Route::get('/{id}', [OrderController::class, 'show']);
        Route::put('/{id}/status', [OrderController::class, 'updateStatus']);
    });




});
