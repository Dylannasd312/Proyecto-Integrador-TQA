<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ArchivoClinico extends Model
{
    protected $table = 'archivos_clinicos';
    
    protected $fillable = [
        'consulta_id',
        'paciente_id',
        'tipo_archivo_id',
        'nombre_archivo',
        'ruta_archivo',
        'observaciones',
        'fecha_subida',
        'usuario_id'
    ];

    protected function casts(): array
    {
        return [
            'fecha_subida' => 'datetime'
        ];
    }

    public function consulta()
    {
        return $this->belongsTo(
            Consulta::class,
            'consulta_id'
        );
    }

    public function paciente()
    {
        return $this->belongsTo(
            Paciente::class,
            'paciente_id'
        );
    }

    public function tipoArchivo()
    {
        return $this->belongsTo(
            TipoArchivoClinico::class,
            'tipo_archivo_id'
        );
    }

    public function usuario()
    {
        return $this->belongsTo(
            User::class,
            'usuario_id'
        );
    }
}
