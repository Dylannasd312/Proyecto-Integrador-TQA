<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cita extends Model
{
    protected $table = 'citas';

    protected $fillable = [
        'paciente_id',
        'medico_id',
        'especialidad_id',
        'consultorio_id',
        'fecha_cita',
        'hora_cita',
        'origen',
        'estado',
        'observaciones'
    ];

    protected function casts(): array
    {
        return [
            'fecha_cita' => 'date',
        ];
    }

    public function paciente()
    {
        return $this->belongsTo(Paciente::class);
    }

    public function medico()
    {
        return $this->belongsTo(Medico::class);
    }

    public function especialidad()
    {
        return $this->belongsTo(Especialidad::class);
    }

    public function consultorio()
    {
        return $this->belongsTo(Consultorio::class);
    }

    public function consulta()
    {
        return $this->hasOne(Consulta::class);
    }
    public function pagoCita()
{
    return $this->hasOne(
        PagoCita::class,
        'cita_id'
    );
}
public function historial()
{
    return $this->hasMany(
        HistorialCita::class,
        'cita_id'
    );
}
}
