<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreCompraRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'usuario_id' =>
    'required|exists:usuarios,id',
            'proveedor_id' =>
                'required|exists:proveedores,id',

            'numero_factura' =>
                'required|string|max:100',

            'fecha_compra' =>
                'required|date',

            'observaciones' =>
                'nullable|string',

            'detalles' =>
                'required|array|min:1',

            'detalles.*.medicamento_id' =>
                'required|exists:medicamentos,id',

            'detalles.*.cantidad' =>
                'required|integer|min:1',

            'detalles.*.precio_unitario' =>
                'required|numeric|min:0.01',

            'detalles.*.numero_lote' =>
                'required|string|max:100',

            'detalles.*.fecha_vencimiento' =>
                'required|date|after:today'
        ];
    }
}
