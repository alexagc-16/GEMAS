<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DiagnosticoTratamiento extends Model
{
    protected $table = 'diagnosticoTratamiento';

    protected $fillable = ['diagnostico', 'tratamiento', 'medicamento', 'dosis', 'frecuencia', 'duracion', 'procedimiento', 'examenOrdenado', 'indicaciones', 'fecha', 'idEvolucion'];

    public function Evolucion(){
        return $this->belongsTo(DiagnosticoTratamiento::class, 'idEvolucion');
    }
}
