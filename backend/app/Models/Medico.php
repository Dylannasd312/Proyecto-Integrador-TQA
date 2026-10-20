<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Medico extends Model
{
    protected $table = 'medicos';

    protected $fillable = [
        'usuario_id',
        'ci',
        'matricula_profesional',
        'nombres',
        'apellido_paterno',
        'apellido_materno',
        'telefono',
        'correo',
        'direccion',
        'fecha_nacimiento',
        'fecha_ingreso',
        'firma_imagen',
        'sello_imagen',
        'estado'
    ];

    protected function casts(): array
    {
        return [
            'fecha_nacimiento' => 'date',
            'fecha_ingreso' => 'date',
            'estado' => 'boolean'
        ];
    }

    public function usuario()
    {
        return $this->belongsTo(User::class, 'usuario_id');
    }

    public function especialidades()
    {
        return $this->belongsToMany(
            Especialidad::class,
            'medico_especialidad',
            'medico_id',
            'especialidad_id'
        );
    }
    public function citas()
{
    return $this->hasMany(Cita::class);
}
public function horarios()
{
    return $this->hasMany(
        HorarioMedico::class,
        'medico_id'
    );
}
public function bloqueosHorario()
{
    return $this->hasMany(
        BloqueoHorario::class,
        'medico_id'
    );
}
}
