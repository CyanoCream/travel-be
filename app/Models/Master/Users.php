<?php

    namespace App\Models\Master;

    use Illuminate\Database\Eloquent\Factories\HasFactory;
    use Illuminate\Foundation\Auth\User as Authenticatable;
    use Illuminate\Notifications\Notifiable;
    use Illuminate\Database\Eloquent\SoftDeletes;

    class Users extends Authenticatable
    {
        use HasFactory, Notifiable, SoftDeletes;

        protected $fillable = [
            'name',
            'email',
            'profile_picture',
            'phone_number',
            'fullname',
            'username',
            'password',
            'address',
            'created_by',
            'updated_by'

        ];

        protected $hidden = [
            'password',
            'remember_token',
        ];

        protected $casts = [
            'email_verified_at' => 'datetime',
            'phone_number' => 'integer',
        ];

        // Business Logic
        public static function createUser($data) {
            $data['password'] = bcrypt($data['password']);
            $data['created_by'] = auth()->user()->name; // Mengambil nama user yang sedang login
            $data['updated_by'] = auth()->user()->name;
            return self::create($data);
        }

        public function updateUser($data) {
            if (isset($data['password'])) {
                $data['password'] = bcrypt($data['password']);
            }
            $data['updated_by'] = auth()->user()->name; // Mengambil nama user yang sedang login
            return $this->update($data);
        }
    }
