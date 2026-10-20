<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateConsultaRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [

            'motivo_consulta' => 'sometimes|nullable|string',

            'enfermedad_actual' => 'sometimes|nullable|string',

            'diagnostico' => 'sometimes|nullable|string',

            'tratamiento' => 'sometimes|nullable|string',

            'observaciones' => 'sometimes|nullable|string',

            'estado' =>
                'sometimes|in:EN_CURSO,FINALIZADA,CANCELADA'
        ];
    }
}
