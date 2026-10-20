<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DespachoReceta extends Model
{
    protected $table = 'despachos_receta';

    public $timestamps = false;

    protected $fillable = [
        'receta_id',
        'usuario_id',
        'fecha_despacho',
        'observaciones'
    ];

    protected function casts(): array
    {
        return [
            'fecha_despacho' => 'datetime'
        ];
    }

    public function receta()
    {
        return $this->belongsTo(
            Receta::class,
            'receta_id'
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
