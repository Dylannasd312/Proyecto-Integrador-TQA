<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateArchivoClinicoRequest extends FormRequest
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

            'tipo_archivo_id' =>
                'required|exists:tipos_archivo_clinico,id',

            'nombre_archivo' =>
                'required|string|max:255',

            'ruta_archivo' =>
                'required|string|max:500',

            'observaciones' =>
                'nullable',

            'usuario_id' =>
                'required|exists:usuarios,id'
        ];
    }
}
