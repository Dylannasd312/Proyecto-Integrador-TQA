<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateBloqueoHorarioRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'fecha_inicio' =>
                'sometimes|date',

            'fecha_fin' =>
                'sometimes|date',

            'motivo' =>
                'nullable|string|max:200',

            'estado' =>
                'sometimes|boolean'
        ];
    }
}
