<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HorarioMedico extends Model
{
    protected $table = 'horarios_medicos';

    protected $fillable = [
        'medico_id',
        'especialidad_id',
        'consultorio_id',
        'dia_semana_id',
        'hora_inicio',
        'hora_fin',
        'estado'
    ];

    protected function casts(): array
    {
        return [
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

    public function especialidad()
    {
        return $this->belongsTo(
            Especialidad::class,
            'especialidad_id'
        );
    }

    public function consultorio()
    {
        return $this->belongsTo(
            Consultorio::class,
            'consultorio_id'
        );
    }

    public function diaSemana()
    {
        return $this->belongsTo(
            DiaSemana::class,
            'dia_semana_id'
        );
    }
}
