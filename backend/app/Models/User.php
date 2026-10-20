<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $table = 'usuarios';

    protected $fillable = [
        'rol_id',
        'username',
        'correo',
        'password',
        'estado',
        'primer_acceso',
        'ultimo_login'
    ];

    protected $hidden = [
        'password',
    ];

    protected function casts(): array
    {
        return [
            'password' => 'hashed',
            'primer_acceso' => 'boolean',
            'ultimo_login' => 'datetime',
        ];
    }

    public function rol()
    {
        return $this->belongsTo(
            Rol::class,
            'rol_id'
        );
    }

    public function medico()
    {
        return $this->hasOne(
            Medico::class,
            'usuario_id'
        );
    }

    public function paciente()
    {
        return $this->hasOne(
            Paciente::class,
            'usuario_id'
        );
    }
}
