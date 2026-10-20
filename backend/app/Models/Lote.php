<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Lote extends Model
{
    protected $table = 'lotes';

   protected $fillable = [
    'compra_id',
    'medicamento_id',
    'numero_lote',
    'fecha_vencimiento',
    'cantidad_inicial',
    'stock_actual',
    'fecha_ingreso',
    'estado'
];

    protected function casts(): array
{
    return [
        'fecha_vencimiento' => 'date',
        'fecha_ingreso' => 'date'
    ];
}

    public function medicamento()
    {
        return $this->belongsTo(
            Medicamento::class,
            'medicamento_id'
        );
    }
    public function compra()
{
    return $this->belongsTo(
        Compra::class,
        'compra_id'
    );
}
}
