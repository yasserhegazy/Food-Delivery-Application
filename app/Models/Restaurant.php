<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Restaurant extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'name',
        'slug',
        'description',
        'cuisine_type',
        'logo',
        'cover_image',
        'phone',
        'email',
        'address',
        'city',
        'latitude',
        'longitude',
        'opening_time',
        'closing_time',
        'delivery_time',
        'minimum_order',
        'delivery_fee',
        'is_active',
        'rating',
        'total_reviews',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'latitude' => 'decimal:7',
        'longitude' => 'decimal:7',
        'minimum_order' => 'decimal:2',
        'delivery_fee' => 'decimal:2',
        'rating' => 'decimal:2',
    ];

    // Relationships
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function categories()
    {
        return $this->hasMany(Category::class)->orderBy('sort_order');
    }

    public function menuItems()
    {
        return $this->hasManyThrough(MenuItem::class, Category::class);
    }

    public function ratings()
    {
        return $this->hasMany(RestaurantRating::class);
    }

    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    // Scopes
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeByCity($query, $city)
    {
        return $query->where('city', $city);
    }

    public function scopeFeatured($query)
    {
        return $query->where('rating', '>=', 4.0)->orderBy('rating', 'desc');
    }

    public function scopeByCuisine($query, $cuisine)
    {
        return $query->where('cuisine_type', $cuisine);
    }

    public function scopeByPriceRange($query, $range)
    {
        // Price ranges: $ (0-15), $$ (15-30), $$$ (30-50), $$$$ (50+)
        $ranges = [
            '$' => [0, 15],
            '$$' => [15, 30],
            '$$$' => [30, 50],
            '$$$$' => [50, 999999],
        ];

        if (isset($ranges[$range])) {
            [$min, $max] = $ranges[$range];
            return $query->whereHas('menuItems', function ($q) use ($min, $max) {
                $q->whereBetween('price', [$min, $max]);
            });
        }

        return $query;
    }

    public function scopeByDeliveryFee($query, $maxFee)
    {
        if ($maxFee === 'free') {
            return $query->where('delivery_fee', 0);
        }
        
        return $query->where('delivery_fee', '<=', $maxFee);
    }

    public function scopeByDeliveryTime($query, $maxTime)
    {
        return $query->where('delivery_time', '<=', $maxTime);
    }

    public function scopeSearch($query, $searchTerm)
    {
        return $query->where(function ($q) use ($searchTerm) {
            $q->where('name', 'like', '%' . $searchTerm . '%')
              ->orWhere('description', 'like', '%' . $searchTerm . '%')
              ->orWhere('cuisine_type', 'like', '%' . $searchTerm . '%');
        });
    }

    public function scopeOpenNow($query)
    {
        $now = now()->format('H:i:s');
        return $query->where(function ($q) use ($now) {
            $q->whereNull('opening_time')
              ->orWhere(function ($q2) use ($now) {
                  $q2->where('opening_time', '<=', $now)
                     ->where('closing_time', '>=', $now);
              });
        });
    }

    // Accessors
    public function getIsOpenAttribute()
    {
        if (!$this->opening_time || !$this->closing_time) {
            return true; // Always open if no hours set
        }

        $now = now()->format('H:i:s');
        return $now >= $this->opening_time && $now <= $this->closing_time;
    }

    public function getAveragePriceAttribute()
    {
        return $this->menuItems()->avg('price') ?? 0;
    }

    public function getPriceRangeAttribute()
    {
        $avgPrice = $this->average_price;
        
        if ($avgPrice < 15) return '$';
        if ($avgPrice < 30) return '$$';
        if ($avgPrice < 50) return '$$$';
        return '$$$$';
    }

    // Static Methods
    public static function getAvailableCuisines()
    {
        return self::whereNotNull('cuisine_type')
            ->distinct()
            ->orderBy('cuisine_type')
            ->pluck('cuisine_type')
            ->filter()
            ->values();
    }

    // Methods
    public function updateRating($newRating)
    {
        $totalRatings = $this->rating * $this->total_reviews;
        $this->total_reviews++;
        $this->rating = ($totalRatings + $newRating) / $this->total_reviews;
        $this->save();
    }

    public function toggleStatus()
    {
        $this->is_active = !$this->is_active;
        $this->save();
    }
}
