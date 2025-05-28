<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Storage;

class Album extends Model
{
    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'band_id',
        'title',
        'cover_path',
        'release_date'
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'release_date' => 'date',
    ];

    /**
     * Relationship with the Band model
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function band(): BelongsTo
    {
        return $this->belongsTo(Band::class);
    }

    /**
     * Get the URL for the album cover
     *
     * @return string|null
     */
    public function getCoverUrlAttribute(): ?string
    {
        return $this->cover_path ? Storage::url($this->cover_path) : null;
    }

    /**
     * Scope a query to order albums by release date (newest first)
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeLatest($query)
    {
        return $query->orderBy('release_date', 'desc');
    }

    /**
     * Delete the album cover from storage when deleting the album
     *
     * @return void
     */
    protected static function booted()
    {
        static::deleting(function ($album) {
            if ($album->isForceDeleting() && $album->cover_path) {
                Storage::delete($album->cover_path);
            }
        });
    }
}
