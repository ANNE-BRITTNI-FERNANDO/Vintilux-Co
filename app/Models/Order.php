<?php

// app/Models/Order.php
namespace App\Models;

use MongoDB\Laravel\Eloquent\Model;

class Order extends Model
{
    protected $connection = 'mongodb';
    protected $collection = 'orders';

    protected $fillable = [
        'user_id',
        'total_amount',
        'first_name',
        'last_name',
        'shipping_address',
        'street_address',
        'city',
        'postal_code',
        'phone_number',
        'payment_method',
        'status',
        'created_at',
        'updated_at'
    ];

    protected $dates = [
        'created_at',
        'updated_at'
    ];

    protected $attributes = [
        'status' => 'pending'
    ];

    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
