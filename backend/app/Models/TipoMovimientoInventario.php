<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TipoMovimientoInventario extends Model
{
    protected $table = 'tipos_movimiento_inventario';

    public $timestamps = false;

    protected $fillable = [
        'nombre',
        'estado'
    ];

    protected function casts(): array
    {
        return [
            'estado' => 'boolean'
        ];
    }
    public function movimientos()
{
    return $this->hasMany(
        MovimientoInventario::class,
        'tipo_movimiento_id'
    );
}
}
