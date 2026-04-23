<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    // These allow the OrderController to save data to these specific columns
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
     * This ensures the price and total are treated as numbers, not strings.
     */
    protected $casts = [
        'price' => 'decimal:2',
        'total' => 'decimal:2',
        'quantity' => 'integer',
    ];

    // Note: We removed $attributes because your HeidiSQL table 
    // already handles the 'pending' default status perfectly.
}