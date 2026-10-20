<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Especialidad extends Model
{
    protected $table = 'especialidades';

    protected $fillable = [
        'nombre',
        'descripcion',
        'precio_consulta',
        'estado'
    ];

    protected function casts(): array
    {
        return [
            'precio_consulta' => 'decimal:2',
            'estado' => 'boolean'
        ];
    }

    public function medicos()
    {
        return $this->belongsToMany(
            Medico::class,
            'medico_especialidad',
            'especialidad_id',
            'medico_id'
        );
    }

    public function consultas()
    {
        return $this->hasMany(
            Consulta::class,
            'especialidad_id'
        );
    }

    public function citas()
    {
        return $this->hasMany(
            Cita::class,
            'especialidad_id'
        );
    }

    public function horariosMedicos()
    {
        return $this->hasMany(
            HorarioMedico::class,
            'especialidad_id'
        );
    }
}
