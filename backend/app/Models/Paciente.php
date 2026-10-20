<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Paciente extends Model
{
    protected $table = 'pacientes';

    protected $fillable = [
        'usuario_id',
        'codigo_paciente',
        'ci',
        'nombres',
        'apellido_paterno',
        'apellido_materno',
        'fecha_nacimiento',
        'sexo_id',
        'grupo_sanguineo_id',
        'estado_civil_id',
        'telefono',
        'correo',
        'direccion',
        'contacto_emergencia',
        'telefono_emergencia',
        'parentesco_id',
        'estado'
    ];

    protected function casts(): array
    {
        return [
            'fecha_nacimiento' => 'date',
            'estado' => 'boolean'
        ];
    }

    public function usuario()
    {
        return $this->belongsTo(
            User::class,
            'usuario_id'
        );
    }

    public function sexo()
    {
        return $this->belongsTo(
            Sexo::class,
            'sexo_id'
        );
    }

    public function grupoSanguineo()
    {
        return $this->belongsTo(
            GrupoSanguineo::class,
            'grupo_sanguineo_id'
        );
    }

    public function estadoCivil()
    {
        return $this->belongsTo(
            EstadoCivil::class,
            'estado_civil_id'
        );
    }

    public function parentesco()
    {
        return $this->belongsTo(
            Parentesco::class,
            'parentesco_id'
        );
    }

    public function historiaClinica()
    {
        return $this->hasOne(
            HistoriaClinica::class,
            'paciente_id'
        );
    }
    public function citas()
{
    return $this->hasMany(Cita::class);
}
public function consultas()
{
    return $this->hasMany(
        Consulta::class,
        'paciente_id'
    );
}

}
