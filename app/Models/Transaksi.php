<?php

namespace App\Models;

use App\Models\Tiket;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Transaksi extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'transaction_date',
        'total_payment',
        'payment_method',
        'payment_status',
        'payment_proof',
        'booking_code',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'transaction_date' => 'datetime',
        'total_payment' => 'decimal:2',
    ];
    
    /**
     * Payment status constants
     */
    const STATUS_PENDING = 'Pending';
    const STATUS_SUCCESS = 'Success';
    const STATUS_FAILED = 'Failed';
    const STATUS_CANCELED = 'Canceled';
    
    /**
     * Get all available payment statuses
     * 
     * @return array
     */
    public static function paymentStatuses(): array
    {
        return [
            self::STATUS_PENDING,
            self::STATUS_SUCCESS,
            self::STATUS_FAILED, 
            self::STATUS_CANCELED
        ];
    }

    /**
     * Get the user that owns the transaksi.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the tickets for this transaction.
     */
    public function tikets(): HasMany
    {
        return $this->hasMany(Tiket::class);
    }
    
    public function tickets(): HasMany
    {
        return $this->hasMany(Tiket::class);
    }
    
    /**
     * Generate a unique booking code
     * 
     * @return string
     */
    public static function generateBookingCode(): string
    {
        $prefix = 'BK';
        $timestamp = now()->format('YmdHis');
        $random = strtoupper(substr(md5(uniqid()), 0, 6));
        return $prefix . $timestamp . $random;
    }
    
    /**
     * Check if the payment is pending
     * 
     * @return bool
     */
    public function isPending(): bool
    {
        return $this->payment_status === self::STATUS_PENDING;
    }
    
    /**
     * Check if the payment is successful
     * 
     * @return bool
     */
    public function isSuccess(): bool
    {
        return $this->payment_status === self::STATUS_SUCCESS;
    }
    
    /**
     * Check if the payment failed
     * 
     * @return bool
     */
    public function isFailed(): bool
    {
        return $this->payment_status === self::STATUS_FAILED;
    }
    
    /**
     * Check if the payment is canceled
     * 
     * @return bool
     */
    public function isCanceled(): bool
    {
        return $this->payment_status === self::STATUS_CANCELED;
    }
}