<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MascotaAdopcion extends Model
{
    protected $table = 'mascotaAdopcion';

    protected $fillable = ['nombre', 'especie', 'raza', 'sexo', 'fechaNacimiento', 'color', 'peso', 'descripcion', 'imagen', 'estado'];

    // Conversión de atributos.
    protected $casts = [
        'fechaNacimiento' => 'date',
        'peso' => 'decimal:2'
    ];
}
