<?php
// app/Http/Requests/UserRequest.php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

// app/Http/Requests/UserRequest.php

    public function rules()
    {
        $rules = [
            'name' => 'required|string|max:255',
            'email' => 'required|email',
            'phone_number' => 'nullable|numeric',
            'fullname' => 'nullable|string|max:255',
            'username' => 'nullable|string|max:255',
            'address' => 'nullable|string',
            'password' => 'required', // Password lama selalu required
            'password_new' => 'nullable|min:6', // Password baru optional
        ];


        return $rules;
    }

    protected function passedValidation()
    {
        // Jika password kosong saat update, hapus dari validated data
        if ($this->isMethod('PUT') || $this->isMethod('PATCH')) {
            if (empty($this->password)) {
                $this->request->remove('password');
            }
        }
    }

    public function attributes()
    {
        return [
            'name' => 'Nama',
            'email' => 'Alamat Email',
            'phone_number' => 'Nomor Telepon',
            'fullname' => 'Nama Lengkap',
            'username' => 'Nama Pengguna',
            'password' => 'Kata Sandi',
            'address' => 'Alamat',
        ];
    }
}
