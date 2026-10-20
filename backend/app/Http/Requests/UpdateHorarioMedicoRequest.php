<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateHorarioMedicoRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'medico_id' =>
                'sometimes|exists:medicos,id',

            'especialidad_id' =>
                'sometimes|exists:especialidades,id',

            'consultorio_id' =>
                'sometimes|exists:consultorios,id',

            'dia_semana_id' =>
                'sometimes|exists:dias_semana,id',

            'hora_inicio' =>
                'sometimes|date_format:H:i',

            'hora_fin' =>
                'sometimes|date_format:H:i',

            'estado' =>
                'nullable|boolean'
        ];
    }
}
