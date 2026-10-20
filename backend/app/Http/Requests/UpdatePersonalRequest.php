<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdatePersonalRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $id = $this->route('id');

        return [

            'usuario_id' =>
                'required|exists:usuarios,id|unique:personal,usuario_id,' . $id,

            'ci' =>
                'required|max:20|unique:personal,ci,' . $id,

            'nombres' => 'required|max:150',

            'apellido_paterno' => 'required|max:100',

            'apellido_materno' => 'nullable|max:100',

            'telefono' => 'nullable|max:50',

            'correo' =>
                'nullable|email|max:150|unique:personal,correo,' . $id,

            'direccion' => 'nullable',

            'fecha_nacimiento' => 'nullable|date',

            'fecha_ingreso' => 'required|date',

            'cargo' => 'required|max:100'
        ];
    }
}
