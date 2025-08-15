<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\Tiket;

class DetailTransaksi extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'transaction_id',
        'ticket_id',
        'ticket_quantity',
        'unit_price',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'unit_price' => 'decimal:2',
    ];

    /**
     * Get the transaction that owns the detail.
     */
    public function transaction(): BelongsTo
    {
        return $this->belongsTo(Transaksi::class, 'transaction_id');
    }

    /**
     * Get the ticket that owns the detail.
     */
    public function ticket(): BelongsTo
    {
        return $this->belongsTo(Tiket::class, 'ticket_id');
    }

    /**
     * Get the subtotal for this detail item.
     *
     * @return float
     */
    public function getSubtotalAttribute(): float
    {
        return $this->ticket_quantity * $this->unit_price;
    }
}
