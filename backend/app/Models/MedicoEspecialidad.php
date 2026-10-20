<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MedicoEspecialidad extends Model
{
    protected $table = 'medico_especialidad';

    public $timestamps = false;

    protected $fillable = [
        'medico_id',
        'especialidad_id'
    ];
}
