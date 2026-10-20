<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateCitaRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'paciente_id' => 'sometimes|exists:pacientes,id',
            'medico_id' => 'sometimes|exists:medicos,id',
            'especialidad_id' => 'sometimes|exists:especialidades,id',
            'consultorio_id' => 'sometimes|exists:consultorios,id',

            'fecha_cita' =>
    'sometimes|date|after_or_equal:today',
            'hora_cita' =>
    'sometimes|date_format:H:i:s',

            'origen' => 'sometimes|in:WEB,APP_MOVIL,RECEPCION',

            'estado' => 'sometimes|in:POR_PAGAR,PENDIENTE,EN_CONSULTA,FINALIZADA,CANCELADA,NO_ASISTIO',

            'observaciones' => 'nullable|string'
        ];
    }
}
