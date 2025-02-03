<?php

namespace App\Models;

// use Illuminate\Database\Eloquent\Model;
use MongoDB\Laravel\Eloquent\Model;

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
    ];
}
