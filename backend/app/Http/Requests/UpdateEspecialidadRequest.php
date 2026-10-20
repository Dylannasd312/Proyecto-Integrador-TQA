<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateEspecialidadRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $id = $this->route('especialidade');

        return [
            'nombre' => [
                'sometimes',
                'string',
                'max:150',
                Rule::unique(
                    'especialidades',
                    'nombre'
                )->ignore($id)
            ],

            'descripcion' =>
                'nullable|string',

            'precio_consulta' =>
                'sometimes|numeric|min:0',

            'estado' =>
                'sometimes|boolean'
        ];
    }
}
