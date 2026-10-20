<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreEspecialidadRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'nombre' =>
                'required|string|max:150|unique:especialidades,nombre',

            'descripcion' =>
                'nullable|string',

            'precio_consulta' =>
                'required|numeric|min:0'
        ];
    }
}
