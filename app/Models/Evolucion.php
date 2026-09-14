<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Evolucion extends Model
{
    protected $table = 'evolucion';
    protected $fillable = ['fecha', 'peso', 'temperatura', 'sintomas', 'observaciones', 'idHistoriaClinica', 'idVeterinario'];

    public function HistoriaClinica(){
        return $this->belongsTo(HistoriaClinica::class, 'idHistoriaClinica');
    }

    public function Veterinario(){
        return $this->belongsTo(Veterinario::class, 'idVeterinario');
    }
}
