<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\WishlistController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\UserController;

Route::get('/', function () {
    $newArrivals = app(App\Http\Controllers\ProductController::class)->getNewArrivals();
    return view('welcome', compact('newArrivals'));
});

Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::view('profile', 'profile')
    ->middleware(['auth'])
    ->name('profile');

require __DIR__.'/auth.php';

Route::resource('posts', PostController::class)
    ->middleware('auth');

// Shop routes
Route::get('/shop', [ProductController::class, 'showAllProducts'])->name('shop');
Route::get('/shop/handbags', [ProductController::class, 'showHandbags'])->name('shop.handbags');
Route::get('/shop/accessories', [ProductController::class, 'showAccessories'])->name('shop.accessories');
Route::get('/shop/product/{id}', [ProductController::class, 'showProductDetails'])->name('shop.product.details');

// Cart Routes
Route::middleware(['auth'])->group(function () {
    Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
    Route::post('/cart', [CartController::class, 'addToCart'])->name('cart.add');
    Route::post('/cart/buy-now', [CartController::class, 'buyNow'])->name('cart.buy-now');

        Route::put('/cart/{cart}', [CartController::class, 'updateQuantity'])->name('cart.update');
        Route::delete('/cart/{cart}', [CartController::class, 'destroy'])->name('cart.destroy');
        Route::delete('/cart', [CartController::class, 'clearCart'])->name('cart.clear');
    });

// Wishlist Routes
Route::middleware(['auth'])->group(function () {
    Route::get('/wishlist', [WishlistController::class, 'index'])->name('wishlist.index');
    Route::post('/wishlist/toggle', [WishlistController::class, 'toggle'])->name('wishlist.toggle');
    Route::get('/wishlist/check/{productId}', [WishlistController::class, 'check'])->name('wishlist.check');
});

// Checkout Routes
Route::middleware(['auth'])->group(function () {
    Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout');
    Route::post('/checkout/process', [CheckoutController::class, 'process'])->name('checkout.process');
    Route::get('/checkout/success', [CheckoutController::class, 'success'])->name('checkout.success');
});

// routes/web.php
Route::middleware(['auth'])->group(function () {
    Route::get('/orders', [OrderController::class, 'index'])->name('orders.index');
    Route::post('/orders', [OrderController::class, 'store'])->name('orders.store');
});

// All admin routes should be under this group
Route::prefix('admin')
    ->middleware('admin')  // This ensures only admins can access these routes
    ->name('admin.')  // This prefixes all route names with 'admin.'
    ->group(function () {
        // Admin dashboard
        Route::get('dashboard', function () {
            return view('admin.dashboard');
        })->name('dashboard');

        // Admin products management
        Route::resource('products', ProductController::class);
        
        // Admin users management
        Route::resource('users', UserController::class);
        Route::get('/admin/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
        
        // Admin orders management
        Route::get('orders', [OrderController::class, 'adminIndex'])->name('orders.index');
        Route::get('orders/{order}', [OrderController::class, 'adminShow'])->name('orders.show');
    });
