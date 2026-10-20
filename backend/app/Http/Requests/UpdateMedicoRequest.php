<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateMedicoRequest extends FormRequest
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
                'required|exists:usuarios,id|unique:medicos,usuario_id,' . $id,

            'ci' =>
                'required|max:20|unique:medicos,ci,' . $id,

            'matricula_profesional' =>
                'required|max:100|unique:medicos,matricula_profesional,' . $id,

            'nombres' =>
                'required|max:150',

            'apellido_paterno' =>
                'required|max:100',

            'apellido_materno' =>
                'nullable|max:100',

            'telefono' =>
                'nullable|max:50',

            'correo' =>
                'nullable|email|max:150|unique:medicos,correo,' . $id,

            'direccion' =>
                'nullable',

            'fecha_nacimiento' =>
                'nullable|date',

            'fecha_ingreso' =>
                'required|date',

            'especialidades' =>
                'required|array|min:1',

            'especialidades.*' =>
                'exists:especialidades,id'
        ];
    }
}
