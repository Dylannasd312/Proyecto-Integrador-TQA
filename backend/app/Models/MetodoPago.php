<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MetodoPago extends Model
{
    protected $table = 'metodos_pago';

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

    public function pagos()
    {
        return $this->hasMany(
            Pago::class,
            'metodo_pago_id'
        );
    }
}
