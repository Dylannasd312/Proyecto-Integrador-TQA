<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreConsultorioRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [

            'codigo' =>
                'required|string|max:20|unique:consultorios,codigo',

            'nombre' =>
                'required|string|max:100',

            'ubicacion' =>
                'nullable|string|max:200'
        ];
    }
}
