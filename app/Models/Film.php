<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Film extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'title',
        'producer',
        'year',
        'duration',
        'sinopsis',
        'poster_url',
        'genre_id',
        'is_showing',
        'release_date',
    ];
    
    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'is_showing' => 'boolean',
        'year' => 'integer',
        'duration' => 'integer',
        'release_date' => 'date',
    ];

    /**
     * Get the genre that owns the film.
     */
    public function genre(): BelongsTo
    {
        return $this->belongsTo(Genre::class);
    }

    /**
     * Get the genres as a collection for compatibility with templates
     * This is a convenience method that acts like a belongs-to-many relationship
     */
    public function genres()
    {
        // Create a collection with just the single genre to maintain template compatibility
        if ($this->genre) {
            return collect([$this->genre]);
        }
        return collect([]);
    }

    /**
     * Get the jadwal_tayangs for the film.
     */
    public function jadwalTayangs(): HasMany
    {
        return $this->hasMany(JadwalTayang::class);
    }
    
    /**
     * Get the synopsis attribute
     * 
     * @return string|null
     */
    public function getSynopsisAttribute()
    {
        // Use sinopsis field as synopsis
        return $this->sinopsis;
    }
    
    /**
     * Get the backdrop path attribute
     * 
     * @return string|null
     */
    public function getBackdropPathAttribute()
    {
        // Use poster_url as backdrop when needed
        return $this->poster_url;
    }
    
    /**
     * Get the poster path attribute
     * 
     * @return string|null
     */
    public function getPosterPathAttribute()
    {
        // Use poster_url as poster_path
        return $this->poster_url;
    }
    
    /**
     * Get the formatted poster URL with fallback
     * 
     * @return string
     */
    public function getFormattedPosterUrlAttribute()
    {
        if (!$this->poster_url) {
            return asset('images/no-poster.jpg');
        }
        
        // Check if the poster_url is already a full URL
        if (filter_var($this->poster_url, FILTER_VALIDATE_URL)) {
            return $this->poster_url;
        }
        
        // Check if the poster_url is a storage path that starts with /storage
        if (str_starts_with($this->poster_url, '/storage')) {
            return $this->poster_url;
        }
        
        // Otherwise assume it's a relative path in storage
        return asset('storage/' . $this->poster_url);
    }
    
    /**
     * Check if the film is releasable (release date has passed)
     * 
     * @return bool
     */
    public function isReleasable()
    {
        if (!$this->release_date) {
            return false;
        }
        
        return $this->release_date->isPast();
    }
}
