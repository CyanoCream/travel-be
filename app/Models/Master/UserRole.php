<?php

namespace App\Models\Master;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class UserRole extends Model
{
    use HasFactory;
    protected $table = "user_role";
    public $timestamps = false;
    protected $fillable = [
        'user_id',
        'role_code',
    ];

    // Relationships
    public function user()
    {
        return $this->belongsTo(Users::class, 'user_id');
    }

    public function role()
    {
        return $this->belongsTo(Role::class, 'role_code', 'code');
    }

    // Business Logic
    public static function createUserRole($data)
    {
        return self::create($data);
    }

    public function updateUserRole($data)
    {
//        $data['updated_by'] = auth()->user()->name;
        return $this->update($data);
    }
}
