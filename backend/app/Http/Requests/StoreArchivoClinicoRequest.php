<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreArchivoClinicoRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'consulta_id' => 'required|exists:consultas,id',
            'paciente_id' => 'required|exists:pacientes,id',
            'tipo_archivo_id' => 'required|exists:tipos_archivo_clinico,id',
            'usuario_id' => 'required|exists:usuarios,id',

            'archivo' => 'required|file|max:10240',

            'observaciones' => 'nullable|string'
        ];
    }
}
