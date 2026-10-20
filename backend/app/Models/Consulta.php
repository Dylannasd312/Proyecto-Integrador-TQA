<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Consulta extends Model
{
    protected $table = 'consultas';

    protected $fillable = [
        'cita_id',
        'paciente_id',
        'medico_id',
        'especialidad_id',
        'fecha_consulta',
        'motivo_consulta',
        'enfermedad_actual',
        'diagnostico',
        'tratamiento',
        'observaciones',
        'estado'
    ];

    protected function casts(): array
    {
        return [
            'fecha_consulta' => 'datetime',
        ];
    }

    public function cita()
    {
        return $this->belongsTo(
            Cita::class,
            'cita_id'
        );
    }

    public function paciente()
    {
        return $this->belongsTo(
            Paciente::class,
            'paciente_id'
        );
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

    public function signosVitales()
    {
        return $this->hasOne(
            SignosVitales::class,
            'consulta_id'
        );
    }

    public function archivosClinicos()
    {
        return $this->hasMany(
            ArchivoClinico::class,
            'consulta_id'
        );
    }

    public function analisisIA()
    {
        return $this->hasMany(
            AnalisisIA::class,
            'consulta_id'
        );
    }
 public function receta()
{
    return $this->hasOne(Receta::class);
}
}
