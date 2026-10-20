<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateConsultorioRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $id = $this->route('id');

        return [

            'codigo' =>
                'required|string|max:20|unique:consultorios,codigo,' . $id,

            'nombre' =>
                'required|string|max:100',

            'ubicacion' =>
                'nullable|string|max:200'
        ];
    }
}
