<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HistorialCita extends Model
{
    protected $table = 'historial_citas';

    public $timestamps = false;

    protected $fillable = [
        'cita_id',
        'estado_anterior',
        'estado_nuevo',
        'observacion',
        'usuario_id',
        'created_at'
    ];

    protected function casts(): array
    {
        return [
            'created_at' => 'datetime'
        ];
    }

    public function cita()
    {
        return $this->belongsTo(
            Cita::class,
            'cita_id'
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
