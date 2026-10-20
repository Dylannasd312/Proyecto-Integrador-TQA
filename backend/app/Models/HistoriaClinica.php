<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HistoriaClinica extends Model
{
    protected $table = 'historias_clinicas';

    protected $fillable = [
        'paciente_id',
        'numero_historia',
        'antecedentes_personales',
        'antecedentes_familiares',
        'alergias',
        'observaciones',
        'estado'
    ];

    protected function casts(): array
    {
        return [
            'estado' => 'boolean'
        ];
    }

    public function paciente()
    {
        return $this->belongsTo(
            Paciente::class,
            'paciente_id'
        );
    }
}
