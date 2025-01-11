<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TblProductPicture extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'product_id',
        'picture',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */


    public function product(): BelongsTo
    {
        return $this->belongsTo(TblProduct::class);
    }
}
