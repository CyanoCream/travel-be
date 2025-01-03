<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TblStockTransaction extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'product_id',
        'merchant_id',
        'transaction_type',
        'quantity',
        'transaction_date',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'product_id' => 'integer',
        'merchant_id' => 'integer',
        'transaction_date' => 'timestamp',
    ];

    public function product(): BelongsTo
    {
        return $this->belongsTo(TblProduct::class);
    }

    public function merchant(): BelongsTo
    {
        return $this->belongsTo(TblMerchant::class);
    }
}
