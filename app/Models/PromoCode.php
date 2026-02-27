<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PromoCode extends Model
{
    protected $fillable = [
        'code',
        'description',
        'discount_type',
        'discount_value',
        'min_order_amount',
        'max_discount',
        'max_uses',
        'current_uses',
        'expires_at',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'expires_at' => 'datetime',
        'discount_value' => 'decimal:2',
        'min_order_amount' => 'decimal:2',
        'max_discount' => 'decimal:2',
    ];

    /**
     * Scope to only valid (active, not expired, uses not exceeded) promo codes.
     */
    public function scopeValid($query)
    {
        return $query->where('is_active', true)
            ->where(function ($q) {
                $q->whereNull('expires_at')
                  ->orWhere('expires_at', '>', now());
            })
            ->where(function ($q) {
                $q->whereNull('max_uses')
                  ->orWhereColumn('current_uses', '<', 'max_uses');
            });
    }

    /**
     * Calculate the discount amount for a given order amount.
     */
    public function calculateDiscount($orderAmount): float
    {
        if ($orderAmount < $this->min_order_amount) {
            return 0;
        }

        if ($this->discount_type === 'percentage') {
            $discount = ($orderAmount * $this->discount_value) / 100;
        } else {
            $discount = (float) $this->discount_value;
        }

        // Cap at max_discount if set
        if ($this->max_discount !== null && $discount > $this->max_discount) {
            $discount = (float) $this->max_discount;
        }

        // Discount cannot exceed order amount
        return min($discount, $orderAmount);
    }

    /**
     * Check if this promo code is currently valid.
     */
    public function isValid(): bool
    {
        if (!$this->is_active) {
            return false;
        }

        if ($this->expires_at && $this->expires_at->isPast()) {
            return false;
        }

        if ($this->max_uses !== null && $this->current_uses >= $this->max_uses) {
            return false;
        }

        return true;
    }

    /**
     * Increment the usage counter.
     */
    public function incrementUses(): void
    {
        $this->increment('current_uses');
    }
}
