<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RoleRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        $rules = [
            'code' => 'required|string|max:50',
            'name' => 'required|string|max:255',
        ];

        return $rules;
    }

    public function attributes()
    {
        return [
            'code' => 'Kode Role',
            'name' => 'Nama Role',
        ];
    }
}
