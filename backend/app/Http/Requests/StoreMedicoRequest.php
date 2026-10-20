<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreMedicoRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [

            'usuario_id' =>
                'required|exists:usuarios,id|unique:medicos,usuario_id',

            'ci' =>
                'required|max:20|unique:medicos,ci',

            'matricula_profesional' =>
                'required|max:100|unique:medicos,matricula_profesional',

            'nombres' =>
                'required|max:150',

            'apellido_paterno' =>
                'required|max:100',

            'apellido_materno' =>
                'nullable|max:100',

            'telefono' =>
                'nullable|max:50',

            'correo' =>
                'nullable|email|max:150|unique:medicos,correo',

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
