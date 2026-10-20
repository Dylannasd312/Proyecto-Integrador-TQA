<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreMedicamentoRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'codigo' => 'required|string|max:50|unique:medicamentos,codigo',
            'nombre' => 'required|string|max:200',
            'descripcion' => 'nullable|string',
            'concentracion' => 'nullable|string|max:100',
            'presentacion' => 'nullable|string|max:100',
            'stock_minimo' => 'required|integer|min:0',
            'precio_compra_promedio' => 'required|numeric|min:0',
            'precio_venta' => 'required|numeric|min:0',
            'estado' => 'boolean'
        ];
    }
}
