<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Receta extends Model
{
    protected $table = 'recetas';

    protected $fillable = [
        'consulta_id',
        'fecha_receta',
        'estado',
        'observaciones'
    ];

    protected function casts(): array
    {
        return [
            'fecha_receta' => 'datetime'
        ];
    }

    public function consulta()
    {
        return $this->belongsTo(Consulta::class);
    }

    public function detalles()
    {
        return $this->hasMany(RecetaDetalle::class);
    }

    public function despacho()
    {
        return $this->hasOne(DespachoReceta::class);
    }
}
