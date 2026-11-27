<?php

namespace App\Repository\Seguridad;

use App\Models\Usuario;

class RecuperarPasswordRepository
{
    /**
     * Buscar un usuario por su correo electrónico.
     */
    public function buscarPorEmail(string $email): ?Usuario
    {
        return Usuario::where('email', $email)->first();
    }

    /**
     * Actualizar la contraseña y el token de recuperación.
     */
    public function actualizarPassword(Usuario $usuario, string $password): void
    {
        $usuario->forceFill([
            'password' => $password,
            'remember_token' => \Illuminate\Support\Str::random(60),
        ])->save();
    }
}
