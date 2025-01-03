<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CityRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'name' => 'required|string|max:255',
            'province_id' => 'required|exists:tbl_provinces,id',
        ];
    }

    public function attributes()
    {
        return [
            'name' => 'Nama Kota',
            'province_id' => 'Provinsi',
        ];
    }
}
