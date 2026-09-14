<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HistoriaClinica extends Model
{
    protected $table = 'historiaClinica';

    protected $fillable = ['fechaApertura', 'antecedentes', 'alergias', 'enfermedadesPrevias', 'observaciones', 'idMascota'];

    public function Mascota(){
        return $this->belongsTo(Mascota::class, 'idMascota');
    }

    public function Evolucion(){
        return $this->hasMany(Evolucion::class);
    }
}
