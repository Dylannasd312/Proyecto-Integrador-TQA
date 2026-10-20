<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreDespachoRecetaRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'receta_id' =>
                'required|exists:recetas,id',

            'usuario_id' =>
                'required|exists:usuarios,id',

            'observaciones' =>
                'nullable|string'
        ];
    }
}
