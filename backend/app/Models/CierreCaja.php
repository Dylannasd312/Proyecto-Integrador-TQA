<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class CierreCaja extends Model
{
    protected $table = 'cierres_caja';

    public $timestamps = false;

    protected $fillable = [
        'usuario_id',
        'fecha',
        'total_efectivo',
        'total_qr',
        'total_general',
        'observaciones',
        'created_at'
    ];

    protected function casts(): array
    {
        return [
            'fecha' => 'date',
            'total_efectivo' => 'decimal:2',
            'total_qr' => 'decimal:2',
            'total_general' => 'decimal:2',
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
