<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PagoReceta extends Model
{
    protected $table = 'pago_recetas';

    public $timestamps = false;

    protected $fillable = [
        'pago_id',
        'receta_id'
    ];

    public function pago()
    {
        return $this->belongsTo(
            Pago::class,
            'pago_id'
        );
    }

    public function receta()
    {
        return $this->belongsTo(
            Receta::class,
            'receta_id'
        );
    }
}
