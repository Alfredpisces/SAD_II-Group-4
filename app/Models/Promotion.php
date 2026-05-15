<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Promotion extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'discount_type',
        'discount_value',
        'start_date',
        'end_date',
        'is_active',
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date'   => 'date',
        'is_active'  => 'boolean',
        'discount_value' => 'decimal:2',
    ];

    public function products(): BelongsToMany
    {
        return $this->belongsToMany(Product::class, 'promotion_product');
    }

    public function isRunning(): bool
    {
        return $this->is_active
            && today()->greaterThanOrEqualTo($this->start_date)
            && today()->lessThanOrEqualTo($this->end_date);
    }

    public function scopeRunning($query)
    {
        return $query->where('is_active', true)
            ->whereDate('start_date', '<=', today())
            ->whereDate('end_date', '>=', today());
    }

    public function applyDiscount(float $originalPrice): float
    {
        if ($this->discount_type === 'percentage') {
            $discounted = $originalPrice * (1 - ((float) $this->discount_value / 100));
        } else {
            $discounted = $originalPrice - (float) $this->discount_value;
        }

        return max(0, round($discounted, 2));
    }

    public function discountLabel(): string
    {
        return $this->discount_type === 'percentage'
            ? rtrim(rtrim(number_format($this->discount_value, 2), '0'), '.') . '% OFF'
            : '₱' . number_format($this->discount_value, 0) . ' OFF';
    }
}
