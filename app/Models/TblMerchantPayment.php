<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TblMerchantPayment extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'merchant_id',
        'order_id',
        'amount',
        'payment_date',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'merchant_id' => 'integer',
        'order_id' => 'integer',
        'amount' => 'decimal',
        'payment_date' => 'timestamp',
    ];

    public function merchant(): BelongsTo
    {
        return $this->belongsTo(TblMerchant::class);
    }
}
