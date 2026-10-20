<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Personal extends Model
{
    protected $table = 'personal';

    protected $fillable = [
        'usuario_id',
        'ci',
        'nombres',
        'apellido_paterno',
        'apellido_materno',
        'telefono',
        'correo',
        'direccion',
        'fecha_nacimiento',
        'fecha_ingreso',
        'cargo',
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
}
