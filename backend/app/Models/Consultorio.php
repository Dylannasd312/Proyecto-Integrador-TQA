<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Consultorio extends Model
{
    protected $table = 'consultorios';

    protected $fillable = [
        'codigo',
        'nombre',
        'ubicacion',
        'estado'
    ];

    protected function casts(): array
    {
        return [
            'estado' => 'boolean'
        ];
    }

    public function citas()
    {
        return $this->hasMany(
            Cita::class,
            'consultorio_id'
        );
    }
    
}
