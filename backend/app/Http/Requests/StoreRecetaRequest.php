<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreRecetaRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'consulta_id' => 'required|exists:consultas,id',
            'observaciones' => 'nullable|string',

            'detalles' => 'required|array|min:1',

            'detalles.*.medicamento_id' =>
                'required|exists:medicamentos,id',

            'detalles.*.cantidad' =>
                'required|integer|min:1',

            'detalles.*.dosis' =>
                'required|string|max:200',

            'detalles.*.frecuencia' =>
                'required|string|max:200',

            'detalles.*.duracion' =>
                'required|string|max:200',

            'detalles.*.indicaciones' =>
                'nullable|string'
        ];
    }
}
