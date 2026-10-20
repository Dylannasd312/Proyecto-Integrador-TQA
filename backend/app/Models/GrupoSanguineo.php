<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GrupoSanguineo extends Model
{
    protected $table = 'grupos_sanguineos';

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

    public function pacientes()
    {
        return $this->hasMany(
            Paciente::class,
            'grupo_sanguineo_id'
        );
    }
}
