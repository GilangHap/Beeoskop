<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Tiket extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'jadwal_tayang_id',
        'kursi_id',
        'price',
        'ticket_status',
        'transaksi_id',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'price' => 'decimal:2',
    ];

    /**
     * Get the jadwal_tayang that owns the ticket.
     */
    public function jadwalTayang(): BelongsTo
    {
        return $this->belongsTo(JadwalTayang::class);
    }

    /**
     * Get the kursi that owns the ticket.
     */
    public function kursi(): BelongsTo
    {
        return $this->belongsTo(Kursi::class);
    }

    /**
     * Get the transaksi that owns the ticket (if sold).
     */
    public function transaksi(): BelongsTo
    {
        return $this->belongsTo(Transaksi::class);
    }
    
    /**
     * Check if the ticket is available
     * 
     * @return bool
     */
    public function isAvailable(): bool
    {
        return $this->status_tiket === 'Available';
    }
    
    /**
     * Check if the ticket is sold
     * 
     * @return bool
     */
    public function isSold(): bool
    {
        return $this->status_tiket === 'Sold';
    }
    
    /**
     * Get the seat number from the related kursi.
     *
     * @return string|null
     */
    public function getSeatNumberAttribute()
    {
        return $this->kursi->chair_number ?? null;
    }
}
