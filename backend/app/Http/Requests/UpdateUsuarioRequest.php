<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateUsuarioRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $id = $this->route('id');

        return [

            'rol_id' => 'required|exists:roles,id',

            'username' =>
                'required|string|max:100|unique:usuarios,username,' . $id,

            'correo' =>
                'nullable|email|max:150|unique:usuarios,correo,' . $id,

            'estado' =>
                'required|in:ACTIVO,INACTIVO,BLOQUEADO'
        ];
    }
}
