<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PagoCita extends Model
{
    protected $table = 'pago_citas';

    public $timestamps = false;

    protected $fillable = [
        'pago_id',
        'cita_id'
    ];

    public function pago()
    {
        return $this->belongsTo(
            Pago::class,
            'pago_id'
        );
    }

    public function cita()
    {
        return $this->belongsTo(
            Cita::class,
            'cita_id'
        );
    }
}
