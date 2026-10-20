<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Proveedor extends Model
{
    protected $table = 'proveedores';

    protected $fillable = [
        'nit',
        'razon_social',
        'telefono',
        'correo',
        'direccion',
        'contacto',
        'estado'
    ];

    protected function casts(): array
    {
        return [
            'estado' => 'boolean'
        ];
    }

    public function compras()
    {
        return $this->hasMany(
            Compra::class,
            'proveedor_id'
        );
    }
}
