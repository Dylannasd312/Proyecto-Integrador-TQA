<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Medicamento extends Model
{
    protected $table = 'medicamentos';

    protected $fillable = [
        'codigo',
        'nombre',
        'descripcion',
        'concentracion',
        'presentacion',
        'stock_minimo',
        'precio_compra_promedio',
        'precio_venta',
        'estado'
    ];

    protected function casts(): array
    {
        return [
            'estado' => 'boolean',
            'precio_compra_promedio' => 'decimal:2',
            'precio_venta' => 'decimal:2'
        ];
    }

    public function detalles()
    {
        return $this->hasMany(
            RecetaDetalle::class,
            'medicamento_id'
        );
    }
    public function compraDetalles()
{
    return $this->hasMany(
        CompraDetalle::class,
        'medicamento_id'
    );
}

public function lotes()
{
    return $this->hasMany(
        Lote::class,
        'medicamento_id'
    );
}

public function movimientosInventario()
{
    return $this->hasMany(
        MovimientoInventario::class,
        'medicamento_id'
    );
}


}
