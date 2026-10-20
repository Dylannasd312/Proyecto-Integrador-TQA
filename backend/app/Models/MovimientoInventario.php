<?php

namespace App\Models;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;

class MovimientoInventario extends Model
{
    protected $table = 'movimientos_inventario';

    public $timestamps = false;

    protected $fillable = [
        'medicamento_id',
        'lote_id',
        'tipo_movimiento_id',
        'cantidad',
        'referencia',
        'observacion',
        'usuario_id',
        'created_at'
    ];

    protected function casts(): array
    {
        return [
            'created_at' => 'datetime'
        ];
    }

    public function medicamento()
    {
        return $this->belongsTo(
            Medicamento::class,
            'medicamento_id'
        );
    }

    public function lote()
    {
        return $this->belongsTo(
            Lote::class,
            'lote_id'
        );
    }
    public function tipoMovimiento()
{
    return $this->belongsTo(
        TipoMovimientoInventario::class,
        'tipo_movimiento_id'
    );
}
public function usuario()
{
    return $this->belongsTo(
        User::class,
        'usuario_id'
    );
}
}
