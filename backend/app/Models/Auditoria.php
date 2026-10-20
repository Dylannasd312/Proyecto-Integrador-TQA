<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;

class Auditoria extends Model
{
    protected $table = 'auditorias';

    public $timestamps = false;

    protected $fillable = [
        'usuario_id',
        'tabla_afectada',
        'registro_id',
        'accion',
        'descripcion',
        'ip',
        'created_at'
    ];

    protected function casts(): array
    {
        return [
            'created_at' => 'datetime'
        ];
    }

    public function usuario()
    {
        return $this->belongsTo(
            User::class,
            'usuario_id'
        );
    }
}
