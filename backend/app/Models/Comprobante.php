<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Comprobante extends Model
{
    protected $table = 'comprobantes';

    public $timestamps = false;

    protected $fillable = [
        'pago_id',
        'numero_comprobante',
        'fecha_emision',
        'total',
        'observaciones'
    ];

    protected function casts(): array
    {
        return [
            'total' => 'decimal:2',
            'fecha_emision' => 'datetime'
        ];
    }

    public function pago()
    {
        return $this->belongsTo(
            Pago::class,
            'pago_id'
        );
    }
}
