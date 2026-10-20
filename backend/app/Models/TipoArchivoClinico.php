<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TipoArchivoClinico extends Model
{
    protected $table = 'tipos_archivo_clinico';

    public $timestamps = false;

    protected $fillable = [
        'nombre',
        'estado'
    ];

    protected function casts(): array
    {
        return [
            'estado' => 'boolean'
        ];
    }

    public function archivosClinicos()
    {
        return $this->hasMany(
            ArchivoClinico::class,
            'tipo_archivo_id'
        );
    }
}
