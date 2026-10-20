<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SignosVitales extends Model
{
    protected $table = 'signos_vitales';

    protected $fillable = [
        'consulta_id',
        'temperatura',
        'frecuencia_cardiaca',
        'frecuencia_respiratoria',
        'presion_arterial',
        'saturacion_oxigeno',
        'peso',
        'talla',
        'imc',
        'observaciones'
    ];

    protected function casts(): array
    {
        return [
            'temperatura' => 'decimal:1',
            'saturacion_oxigeno' => 'decimal:2',
            'peso' => 'decimal:2',
            'talla' => 'decimal:2',
            'imc' => 'decimal:2'
        ];
    }

    public function consulta()
    {
        return $this->belongsTo(
            Consulta::class,
            'consulta_id'
        );
    }
}
