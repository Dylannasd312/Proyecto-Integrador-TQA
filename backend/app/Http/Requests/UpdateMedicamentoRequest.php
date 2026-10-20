<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateMedicamentoRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'codigo' => 'sometimes|string|max:50',
            'nombre' => 'sometimes|string|max:200',
            'descripcion' => 'nullable|string',
            'concentracion' => 'nullable|string|max:100',
            'presentacion' => 'nullable|string|max:100',
            'stock_minimo' => 'sometimes|integer|min:0',
            'precio_compra_promedio' => 'sometimes|numeric|min:0',
            'precio_venta' => 'sometimes|numeric|min:0',
            'estado' => 'boolean'
        ];
    }
}
