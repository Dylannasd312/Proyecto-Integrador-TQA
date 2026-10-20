<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StorePagoRecetaRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'receta_id' => [
                'required',
                'integer',
                'exists:recetas,id'
            ],

            'metodo_pago_id' => [
                'required',
                'integer',
                'exists:metodos_pago,id'
            ],

            'usuario_id' => [
                'required',
                'integer',
                'exists:usuarios,id'
            ],

            'observaciones' => [
                'nullable',
                'string'
            ]
        ];
    }

    public function messages(): array
    {
        return [
            'receta_id.required' =>
                'La receta es obligatoria',

            'receta_id.exists' =>
                'La receta no existe',

            'metodo_pago_id.required' =>
                'Debe seleccionar un método de pago',

            'metodo_pago_id.exists' =>
                'Método de pago inválido',

            'usuario_id.required' =>
                'Debe indicar el usuario que registra el pago',

            'usuario_id.exists' =>
                'Usuario inválido'
        ];
    }
}
