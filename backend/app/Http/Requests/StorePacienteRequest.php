<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StorePacienteRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [


            'codigo_paciente' =>
                'required|string|max:20|unique:pacientes,codigo_paciente',

            'ci' =>
                'required|string|max:20|unique:pacientes,ci',

            'nombres' =>
                'required|string|max:150',

            'apellido_paterno' =>
                'required|string|max:100',

            'apellido_materno' =>
                'nullable|string|max:100',

            'fecha_nacimiento' =>
                'required|date',

            'sexo_id' =>
                'required|exists:sexos,id',

            'grupo_sanguineo_id' =>
                'nullable|exists:grupos_sanguineos,id',

            'estado_civil_id' =>
                'nullable|exists:estados_civiles,id',

            'telefono' =>
                'nullable|string|max:50',

            'correo' =>
                'nullable|email|max:150|unique:pacientes,correo',

            'direccion' =>
                'nullable|string',

            'contacto_emergencia' =>
                'nullable|string|max:150',

            'telefono_emergencia' =>
                'nullable|string|max:50',

            'parentesco_id' =>
                'nullable|exists:parentescos,id'
        ];
    }
}
