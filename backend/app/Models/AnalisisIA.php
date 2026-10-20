<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AnalisisIA extends Model
{
    protected $table = 'analisis_ia';

    public $timestamps = false;

    protected $fillable = [
        'consulta_id',
        'paciente_id',
        'medico_id',
        'archivo_clinico_id',
        'resultado',
        'confianza',
        'observaciones',
        'fecha_analisis'
    ];

    protected function casts(): array
    {
        return [
            'confianza' => 'decimal:2',
            'fecha_analisis' => 'datetime'
        ];
    }

    public function consulta()
    {
        return $this->belongsTo(Consulta::class);
    }

    public function paciente()
    {
        return $this->belongsTo(Paciente::class);
    }

    public function medico()
    {
        return $this->belongsTo(Medico::class);
    }

    public function archivoClinico()
    {
        return $this->belongsTo(
            ArchivoClinico::class,
            'archivo_clinico_id'
        );
    }
}
