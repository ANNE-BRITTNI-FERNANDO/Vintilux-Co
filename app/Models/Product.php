<?php

namespace App\Models;

use MongoDB\Laravel\Eloquent\Model;
use App\Models\Cart;
use App\Models\Wishlist;

class Product extends Model
{
    protected $connection = 'mongodb';
    protected $collection = 'products';
    
    protected $fillable = [
        'product_name',
        'product_description',
        'product_price',
        'product_size',
        'product_colors',
        'product_category',
        'product_image',
        'product_gallery',
        'product_status',
        'product_quantity',
    ];

    protected $casts = [
        'product_colors' => 'array',
        'product_gallery' => 'array',
        'product_price' => 'float',
        'product_quantity' => 'integer',
    ];

    public function carts()
    {
        return $this->hasMany(Cart::class, 'product_id', '_id');
    }

    public function wishlists()
    {
        return $this->hasMany(Wishlist::class, 'product_id', '_id');
    }
}
