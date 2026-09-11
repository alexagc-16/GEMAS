<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Veterinario extends Model
{
    protected $table= 'veterinario';

    protected $fillable = ['nombre', 'apellido', 'documentoIdentidad', 'telefono', 'correo', 'especialidad'];

    public function Horario(){
        return $this->hasMany(Horario::class);
    }
}
