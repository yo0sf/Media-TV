<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Series extends Model
{
    use HasFactory;

    protected $fillable = [
        'slug',
        'title_en',
        'title_ar',
        'synopsis_en',
        'synopsis_ar',
        'type',
        'status',
        'total_episodes',
        'release_year',
        'poster_image',
    ];

    public function genres(): BelongsToMany
    {
        return $this->belongsToMany(Genre::class, 'series_genres');
    }

    public function episodes(): HasMany
    {
        return $this->hasMany(Episode::class)->orderBy('episode_number');
    }

    public function watchlists(): HasMany
    {
        return $this->hasMany(Watchlist::class);
    }

    public function reviews(): HasMany
    {
        return $this->hasMany(Review::class)->where('is_approved', true);
    }

    public function allReviews(): HasMany
    {
        return $this->hasMany(Review::class);
    }

    public function getLocalizedTitleAttribute(): string
    {
        if (app()->getLocale() === 'ar' && !empty($this->title_ar)) {
            return $this->title_ar;
        }
        return $this->title_en;
    }

    public function getLocalizedSynopsisAttribute(): string
    {
        if (app()->getLocale() === 'ar' && !empty($this->synopsis_ar)) {
            return $this->synopsis_ar;
        }
        return $this->synopsis_en;
    }

    public function getAverageRatingAttribute(): float
    {
        return round($this->reviews()->avg('rating') ?? 0, 1);
    }

    public function getPosterImageAttribute(?string $value): string
    {
        if (empty($value)) {
            return 'https://images.unsplash.com/photo-1578328819058-b69f3a3b0f6b?w=600&auto=format&fit=crop&q=80';
        }

        if (str_starts_with($value, 'http://') || str_starts_with($value, 'https://') || str_starts_with($value, '/storage/')) {
            return $value;
        }

        return asset('storage/' . $value);
    }
}
