<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cita extends Model
{
    protected $table = 'cita';

    protected $fillable = ['fecha', 'hora', 'motivo', 'estado', 'idMascota', 'idVeterinario', 'idServicio'];

    public function Mascota(){
        return $this->belongsTo(Mascota::class, 'idMascota');
    }

    public function Veterinario(){
        return $this->belongsTo(Veterinario::class, 'idVeterinario');
    }

    public function Servicio(){
        return $this->belongsTo(Servicio::class, 'idServicio');
    }

}
