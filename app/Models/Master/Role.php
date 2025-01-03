<?php

namespace App\Models\Master;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Role extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = "role";
    protected $fillable = [
        'code',
        'name',
        'created_by',
        'updated_by'
    ];

    // Business Logic
    public static function createRole($data)
    {
        $data['created_by'] = auth()->user()->name;
        $data['updated_by'] = auth()->user()->name;
        return self::create($data);
    }

    public function updateRole($data)
    {
        $data['updated_by'] = auth()->user()->name;
        return $this->update($data);
    }
}
