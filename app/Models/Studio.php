<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Studio extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'name',
        'capacity'
    ];

    /**
     * Get the kursis (seats) for the studio.
     */
    public function kursis(): HasMany
    {
        return $this->hasMany(Kursi::class);
    }

    /**
     * Get the jadwal tayangs (screening schedules) for the studio.
     */
    public function jadwalTayangs(): HasMany
    {
        return $this->hasMany(JadwalTayang::class);
    }
}
