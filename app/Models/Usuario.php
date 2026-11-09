<?php

namespace App\Models;

use App\Models\Concerns\TieneRolesActivos;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

/**
 * @method bool tieneRolActivo(string $nombreRol)
 */
class Usuario extends Authenticatable
{

    use HasFactory, Notifiable, TieneRolesActivos;

    protected $table= 'usuario';

    protected $fillable = ['nombre', 'apellido', 'documentoIdentidad', 'telefono', 'direccion','email', 'password', 'cuentaDesactivadaEn'];

    protected $hidden = ['password', 'remember_token'];

     protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'cuentaDesactivadaEn' => 'datetime',
        ];
    }

    public function tieneRolActivo(string $nombreRol): bool
    {
        return $this->roles()
            ->where('name', $nombreRol)
            ->exists();
    }

    public function Mascota(){
        return $this->hasMany(Mascota::class, 'idUsuario', 'id');
    }
}