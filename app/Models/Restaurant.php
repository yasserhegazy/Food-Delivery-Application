<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Restaurant extends Model
{
    protected $fillable = [
        'user_id',
        'name',
        'slug',
        'description',
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

    // Accessors
    public function getIsOpenAttribute()
    {
        if (!$this->opening_time || !$this->closing_time) {
            return true; // Always open if no hours set
        }

        $now = now()->format('H:i:s');
        return $now >= $this->opening_time && $now <= $this->closing_time;
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
