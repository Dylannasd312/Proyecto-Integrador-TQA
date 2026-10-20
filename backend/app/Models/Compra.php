<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Compra extends Model
{
    protected $table = 'compras';

    protected $fillable = [
    'proveedor_id',
    'usuario_id',
    'numero_factura',
    'fecha_compra',
    'monto_total',
    'estado',
    'observaciones'
];

    protected function casts(): array
    {
        return [
            'fecha_compra' => 'date',
            'monto_total' => 'decimal:2'
        ];
    }

    public function proveedor()
    {
        return $this->belongsTo(
            Proveedor::class,
            'proveedor_id'
        );
    }
    public function usuario()
{
    return $this->belongsTo(
        User::class,
        'usuario_id'
    );
}
    public function detalles()
    {
        return $this->hasMany(
            CompraDetalle::class,
            'compra_id'
        );
    }
}
