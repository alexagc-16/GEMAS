<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CancelacionCita extends Model
{
    protected $table = 'cancelacionCita';

    protected $fillable = ['tipoCancelador', 'motivo', 'fechaCancelacion', 'idCita'];

    protected $casts = [
        'fechaCancelacion' => 'datetime',
    ];

    public function Cita(){
        return $this->belongsTo(Cita::class, 'idCita');
    }
}
