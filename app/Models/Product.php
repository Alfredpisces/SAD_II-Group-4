<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'category',
        'stock',
        'unit',
        'min_stock',
        'price',
    ];

    protected $casts = [
        'price' => 'decimal:2',
    ];

    public function promotions(): BelongsToMany
    {
        return $this->belongsToMany(Promotion::class, 'promotion_product');
    }

    public function isLowStock()
    {
        return $this->stock <= $this->min_stock;
    }

    public function activePromotion(): ?Promotion
    {
        $originalPrice = (float) $this->price;

        return $this->promotions()
            ->running()
            ->get()
            ->sortBy(fn (Promotion $promotion) => $promotion->applyDiscount($originalPrice))
            ->first();
    }

    public function salePrice(): float
    {
        $originalPrice = (float) $this->price;
        $promotion = $this->activePromotion();

        return $promotion
            ? $promotion->applyDiscount($originalPrice)
            : $originalPrice;
    }

    public function hasActiveDiscount(): bool
    {
        return $this->salePrice() < (float) $this->price;
    }
}