<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreUsuarioRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'rol_id' => 'required|exists:roles,id',

            'username' => 'required|string|max:100|unique:usuarios,username',

            'correo' => 'nullable|email|max:150|unique:usuarios,correo',

            'password' => 'required|min:6',

            'estado' => 'required|in:ACTIVO,INACTIVO,BLOQUEADO'
        ];
    }
}
