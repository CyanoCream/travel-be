<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SubdistrictRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'name' => 'required|string|max:255',
            'cities_id' => 'required|exists:tbl_cities,id',
        ];
    }

    public function attributes()
    {
        return [
            'name' => 'Nama Kecamatan',
            'cities_id' => 'Kota',
        ];
    }
}
