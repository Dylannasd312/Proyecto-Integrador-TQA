<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RecetaDetalle extends Model
{
    protected $table = 'receta_detalles';

    public $timestamps = false;

    protected $fillable = [
        'receta_id',
        'medicamento_id',
        'cantidad',
        'dosis',
        'frecuencia',
        'duracion',
        'indicaciones'
    ];

    public function receta()
    {
        return $this->belongsTo(Receta::class);
    }

    public function medicamento()
    {
        return $this->belongsTo(Medicamento::class);
    }
}
