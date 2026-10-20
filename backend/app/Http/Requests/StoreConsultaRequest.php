<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreConsultaRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'cita_id' => 'required|exists:citas,id|unique:consultas,cita_id',

            'paciente_id' => 'required|exists:pacientes,id',

            'medico_id' => 'required|exists:medicos,id',

            'especialidad_id' => 'required|exists:especialidades,id',

            'motivo_consulta' => 'nullable|string',

            'enfermedad_actual' => 'nullable|string',

            'diagnostico' => 'nullable|string',

            'tratamiento' => 'nullable|string',

            'observaciones' => 'nullable|string',

            'estado' =>
                'nullable|in:EN_CURSO,FINALIZADA,CANCELADA'
        ];
    }
}
