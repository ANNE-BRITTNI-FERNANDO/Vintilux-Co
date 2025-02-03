<?php

namespace App\Models;

use MongoDB\Laravel\Eloquent\Model;
use MongoDB\BSON\ObjectId;
use Illuminate\Support\Facades\Auth;

class Cart extends Model
{
    protected $connection = 'mongodb';
    protected $collection = 'carts';
    
    protected $fillable = [
        'user_id',
        'product_id',
        'quantity',
        'color',
        'price',
    ];

    protected $with = ['product'];

    protected function getProductIdAttribute($value)
    {
        return $value instanceof ObjectId ? $value : new ObjectId($value);
    }

    protected function getUserIdAttribute($value)
    {
        return $value instanceof ObjectId ? $value : new ObjectId($value);
    }

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id', '_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', '_id');
    }

    protected static function boot()
    {
        parent::boot();
        
        static::creating(function ($cart) {
            if (!$cart->user_id) {
                $cart->user_id = Auth::id();
            }
        });
    }
}
