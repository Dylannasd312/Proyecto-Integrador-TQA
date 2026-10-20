<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateSignosVitalesRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $id = $this->route('signos_vitale');

        return [

            'consulta_id' =>
                'required|exists:consultas,id|unique:signos_vitales,consulta_id,' . $id,

            'temperatura' =>
                'nullable|numeric|min:30|max:45',

            'frecuencia_cardiaca' =>
                'nullable|integer|min:20|max:250',

            'frecuencia_respiratoria' =>
                'nullable|integer|min:5|max:100',

            'presion_arterial' =>
                'nullable|max:20',

            'saturacion_oxigeno' =>
                'nullable|numeric|min:0|max:100',

            'peso' =>
                'nullable|numeric|min:0',

            'talla' =>
                'nullable|numeric|min:0',

            'observaciones' =>
                'nullable'
        ];
    }
}
