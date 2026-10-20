<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreBloqueoHorarioRequest extends FormRequest
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

            'fecha_inicio' =>
                'required|date',

            'fecha_fin' =>
                'required|date|after:fecha_inicio',

            'motivo' =>
                'nullable|string|max:200'
        ];
    }
}
