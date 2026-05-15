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
        'original_price',
        'promotion_id',
        'total',
        'status',
        'user_id',
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'original_price' => 'decimal:2',
        'total' => 'decimal:2',
        'quantity' => 'integer',
    ];

    public function promotion()
    {
        return $this->belongsTo(Promotion::class);
    }

    public function hasDiscount(): bool
    {
        return $this->original_price !== null
            && (float) $this->original_price > (float) $this->price;
    }

    // Note: We removed $attributes because your HeidiSQL table 
    // already handles the 'pending' default status perfectly.
}