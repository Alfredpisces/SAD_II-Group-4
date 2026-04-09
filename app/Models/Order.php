<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model

{
    // These MUST match your database column names exactly
    protected $fillable = [
        'item_name',
        'quantity',
        'price',
        'total',
        'status',
        'user_id'
    ];

    /**
     * The attributes that should be cast.
     * This ensures the Barista sees correct numbers, not strings.
     */
    protected $casts = [
        'price' => 'decimal:2',
        'total' => 'decimal:2',
        'quantity' => 'integer',
    ];

    /**
     * Default values for attributes.
     * This ensures every order starts as 'pending' automatically.
     */
    protected $attributes = [
        'status' => 'pending',
    ];
}