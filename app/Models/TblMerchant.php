<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;

class TblMerchant extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'display_picture',
        'city_id',
        'address',
        'contact_person',
        'status',
        'is_active',
        'created_by',
        'updated_by',
        'deleted_by'
    ];

    protected $casts = [
        'id' => 'integer',
        'name' => 'string',
        'city_id' => 'integer',
        'address' => 'string',
        'contact_person' => 'string',
        'status' => 'boolean',
        'is_active' => 'boolean'
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $model->created_by = Auth::id();
            $model->updated_by = Auth::id();
            $model->is_active = true;
        });

        static::updating(function ($model) {
            $model->updated_by = Auth::id();
        });

        static::deleting(function ($model) {
            $model->deleted_by = Auth::id();
            $model->save();
        });
    }
}
