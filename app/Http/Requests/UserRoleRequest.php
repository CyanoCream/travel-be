<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserRoleRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'user_id' => 'required|exists:users,id',
            'role_code' => 'required|exists:role,code',
        ];
    }

    public function attributes()
    {
        return [
            'user_id' => 'Pengguna',
            'role_code' => 'Role',
        ];
    }
}
