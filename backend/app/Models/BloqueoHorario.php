<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BloqueoHorario extends Model
{
    protected $table = 'bloqueos_horario';

    public $timestamps = false;

    protected $fillable = [
        'medico_id',
        'fecha_inicio',
        'fecha_fin',
        'motivo',
        'estado'
    ];

    protected function casts(): array
    {
        return [
            'fecha_inicio' => 'datetime',
            'fecha_fin' => 'datetime',
            'estado' => 'boolean'
        ];
    }

    public function medico()
    {
        return $this->belongsTo(
            Medico::class,
            'medico_id'
        );
    }
}
