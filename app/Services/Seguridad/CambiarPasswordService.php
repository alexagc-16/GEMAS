<?php

namespace App\Services\Seguridad;

use App\Repository\Seguridad\UsuarioRepository;
use Illuminate\Support\Facades\Hash;

class CambiarPasswordService
{
    private UsuarioRepository $usuario_seguridad_repository;

    public function __construct(UsuarioRepository $usuarioseguridadrepository)
    {
        $this->usuario_seguridad_repository = $usuarioseguridadrepository;
    }

    public function cambiarPassword($usuario, array $datos): bool
    {
        // Verificar la contraseña actual
        if (!Hash::check($datos['passwordActual'], $usuario->password)) {
            return false;
        }

        // Actualizar la contraseña
        $this->usuario_seguridad_repository->actualizar($usuario, [
            'password' => $datos['password'],
        ]);

        return true;
    }
}