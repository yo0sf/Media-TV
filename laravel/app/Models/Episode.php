<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Episode extends Model
{
    use HasFactory;

    protected $fillable = [
        'series_id',
        'episode_number',
        'title_en',
        'title_ar',
        'air_date',
        'thumbnail_image',
    ];

    public function series(): BelongsTo
    {
        return $this->belongsTo(Series::class);
    }

    public function getLocalizedTitleAttribute(): string
    {
        if (app()->getLocale() === 'ar' && !empty($this->title_ar)) {
            return $this->title_ar;
        }
        return $this->title_en ?? ('Episode ' . $this->episode_number);
    }

    public function getThumbnailUrlAttribute(): ?string
    {
        if (empty($this->thumbnail_image)) {
            return null;
        }
        if (str_starts_with($this->thumbnail_image, 'http://') || str_starts_with($this->thumbnail_image, 'https://') || str_starts_with($this->thumbnail_image, '/storage/')) {
            return $this->thumbnail_image;
        }
        return asset('storage/' . $this->thumbnail_image);
    }
}
