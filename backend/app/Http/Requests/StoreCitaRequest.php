<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreCitaRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'paciente_id' => 'required|exists:pacientes,id',
            'medico_id' => 'required|exists:medicos,id',
            'especialidad_id' => 'required|exists:especialidades,id',
            'consultorio_id' => 'required|exists:consultorios,id',

            'fecha_cita' => 'required|date|after_or_equal:today',
            'hora_cita' =>
    'required|date_format:H:i:s',

            'origen' => 'required|in:WEB,APP_MOVIL,RECEPCION',

            'estado' => 'nullable|in:POR_PAGAR,PENDIENTE,EN_CONSULTA,FINALIZADA,CANCELADA,NO_ASISTIO',

            'observaciones' => 'nullable|string'
        ];
    }
}
