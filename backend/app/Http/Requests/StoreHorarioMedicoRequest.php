<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreHorarioMedicoRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'medico_id' =>
                'required|exists:medicos,id',

            'especialidad_id' =>
                'required|exists:especialidades,id',

            'consultorio_id' =>
                'required|exists:consultorios,id',

            'dia_semana_id' =>
                'required|exists:dias_semana,id',

            'hora_inicio' =>
                'required|date_format:H:i',

            'hora_fin' =>
                'required|date_format:H:i|after:hora_inicio',

            'estado' =>
                'nullable|boolean'
        ];
    }
}
