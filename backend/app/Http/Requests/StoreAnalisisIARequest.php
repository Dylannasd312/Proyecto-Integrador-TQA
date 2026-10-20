<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreAnalisisIARequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'consulta_id' =>
                'required|exists:consultas,id',

            'paciente_id' =>
                'required|exists:pacientes,id',

            'medico_id' =>
                'required|exists:medicos,id',

            'archivo_clinico_id' =>
                'required|exists:archivos_clinicos,id',

            'resultado' =>
                'required|string|max:100',

            'confianza' =>
                'required|numeric|min:0|max:100',

            'observaciones' =>
                'nullable|string'
        ];
    }
}
