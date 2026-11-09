<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Mascota extends Model
{
    protected $table = 'mascota';

    protected $fillable = ['nombre', 'imagen', 'especie', 'raza', 'sexo', 'fechaNacimiento', 'color', 'peso', 'idUsuario'];

    public function Usuario(){
        return $this->belongsTo(Usuario::class, 'idUsuario');
    }

    public function HistoriaClinica(){
        return $this->hasOne(HistoriaClinica::class, 'idMascota');
    }

    public function Cita(){
        return $this->hasMany(Cita::class);
    }
}

