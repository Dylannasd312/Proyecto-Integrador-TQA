<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreProveedorRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'nit' => 'nullable|string|max:50',

            'razon_social' =>
                'required|string|max:200',

            'telefono' =>
                'nullable|string|max:50',

            'correo' =>
                'nullable|email|max:150',

            'direccion' =>
                'nullable|string',

            'contacto' =>
                'nullable|string|max:150',

            'estado' =>
                'boolean'
        ];
    }
}
