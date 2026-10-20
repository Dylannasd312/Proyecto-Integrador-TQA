<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Sexo extends Model
{
    protected $table = 'sexos';

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
            'sexo_id'
        );
    }
}
