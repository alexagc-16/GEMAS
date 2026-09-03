<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Usuario extends Model
{
    protected $table= 'usuario';

    protected $fillable = ['nombre', 'apellido', 'documentoIdentidad', 'telefono', 'correo', 'direccion'];

    public function Mascota(){
        return $this->HasMany(Mascota::class);
    }
}
