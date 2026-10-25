<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Watchlist extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'series_id',
        'status',
        'progress_episodes',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function series(): BelongsTo
    {
        return $this->belongsTo(Series::class);
    }

    public function getProgressPercentageAttribute(): int
    {
        if (!$this->series || $this->series->total_episodes == 0) {
            return 0;
        }
        return min(100, (int) round(($this->progress_episodes / $this->series->total_episodes) * 100));
    }
}
