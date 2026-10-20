<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;
class Pago extends Model
{
    protected $table = 'pagos';

    protected $fillable = [
        'paciente_id',
        'metodo_pago_id',
        'tipo_pago',
        'monto',
        'estado',
        'observaciones',
        'usuario_id',
        'fecha_pago'
    ];

    protected function casts(): array
    {
        return [
            'monto' => 'decimal:2',
            'fecha_pago' => 'datetime'
        ];
    }

    public function paciente()
    {
        return $this->belongsTo(
            Paciente::class,
            'paciente_id'
        );
    }

public function usuario()
{
    return $this->belongsTo(
        User::class,
        'usuario_id'
    );
}

    public function metodoPago()
    {
        return $this->belongsTo(
            MetodoPago::class,
            'metodo_pago_id'
        );
    }

    public function pagoReceta()
    {
        return $this->hasOne(
            PagoReceta::class,
            'pago_id'
        );
    }

    public function comprobante()
    {
        return $this->hasOne(
            Comprobante::class,
            'pago_id'
        );
    }
    public function pagoCita()
{
    return $this->hasOne(
        PagoCita::class,
        'pago_id'
    );
}
}
