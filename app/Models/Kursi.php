<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Kursi extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'studio_id',
        'chair_number',
        'line',
        'coloumn',
    ];

    /**
     * Get the studio that owns the kursi.
     */
    public function studio(): BelongsTo
    {
        return $this->belongsTo(Studio::class);
    }
}
