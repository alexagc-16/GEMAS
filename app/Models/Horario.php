<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Horario extends Model
{
    protected $table = 'horario'; 

    protected $fillable = ['diaSemana', 'horaInicio', 'horaFin', 'idVeterinario'];

    public function Veterinario(){
        return $this->belongsTo(Veterinario::class, 'idVeterinario');
    }
}
