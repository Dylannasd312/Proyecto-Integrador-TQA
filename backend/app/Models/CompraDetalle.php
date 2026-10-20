<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CompraDetalle extends Model
{
    protected $table = 'compra_detalles';

    public $timestamps = false;

    protected $fillable = [
    'compra_id',
    'medicamento_id',
    'cantidad',
    'precio_unitario',
    'subtotal',
    'numero_lote',
    'fecha_vencimiento'
];

    protected function casts(): array
{
    return [
        'precio_unitario' => 'decimal:2',
        'subtotal' => 'decimal:2',
        'fecha_vencimiento' => 'date'
    ];
}

    public function compra()
    {
        return $this->belongsTo(
            Compra::class,
            'compra_id'
        );
    }

    public function medicamento()
    {
        return $this->belongsTo(
            Medicamento::class,
            'medicamento_id'
        );
    }
}
