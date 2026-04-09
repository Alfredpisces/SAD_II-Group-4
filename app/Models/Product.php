<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     * These MUST match the columns in your migrations/seeder.
     */
    protected $fillable = [
        'name',
        'category',
        'stock',
        'unit',
        'min_stock',
        'price',
    ];

    /**
     * Helper method to check if an item is low on stock.
     * Useful for your Admin Dashboard analytics.
     */
    public function isLowStock()
    {
        return $this->stock <= $this->min_stock;
    }
}