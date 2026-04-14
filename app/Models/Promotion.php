<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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

    /**
     * Check if the promotion is currently active and within its date range.
     */
    public function isRunning(): bool
    {
        return $this->is_active
            && today()->greaterThanOrEqualTo($this->start_date)
            && today()->lessThanOrEqualTo($this->end_date);
    }
}
