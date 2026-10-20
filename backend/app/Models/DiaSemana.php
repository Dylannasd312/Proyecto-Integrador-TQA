<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DiaSemana extends Model
{
    protected $table = 'dias_semana';

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

    public function horarios()
    {
        return $this->hasMany(
            HorarioMedico::class,
            'dia_semana_id'
        );
    }
}
