<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TblSalesReport extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'merchant_id',
        'product_id',
        'total_sales',
        'sales_quantity',
        'report_month',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'merchant_id' => 'integer',
        'product_id' => 'integer',
        'total_sales' => 'decimal',
        'sales_quantity' => 'integer',
        'report_month' => 'date',
    ];

    public function merchant(): BelongsTo
    {
        return $this->belongsTo(TblMerchant::class);
    }

    public function product(): BelongsTo
    {
        return $this->belongsTo(TblProduct::class);
    }
}
