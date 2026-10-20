<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StorePagoCitaRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'cita_id' =>
                'required|exists:citas,id',

            'metodo_pago_id' =>
                'required|exists:metodos_pago,id',

            'usuario_id' =>
                'required|exists:usuarios,id',

            'monto' =>
                'required|numeric|min:0.01',

            'observaciones' =>
                'nullable|string'
        ];
    }
}
