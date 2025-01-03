<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Str;



class TblProduct extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'product_name',
        'merchan_id',
        'type',
        'price',
        'stock',
        'category_id',
        'description',
        'status',
        'slug',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected static function boot()
    {
        parent::boot();

        static::saving(function ($product) {
            // Ambil nama merchant
            $merchantName = $product->merchant ? $product->merchant->name : '';

            // Ambil nama kategori
            $categoryName = $product->category ? $product->category->name : '';

            // Generate slug
            $product->slug = Str::slug($merchantName . ' ' . $categoryName . ' ' . $product->product_name);
        });
    }


    public function category(): BelongsTo
    {
        return $this->belongsTo(TblProductCategory::class);
    }
    public function merchant(): BelongsTo
    {
        return $this->belongsTo(TblMerchant::class, 'merchan_id');
    }

}
