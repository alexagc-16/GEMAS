<?php

namespace App\Services\Seguridad;

use App\Models\Usuario;
use App\Repository\Seguridad\UsuarioRepository;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;

class RestablecerPasswordService
{
    private UsuarioRepository $usuario_seguridad_repository;

    public function __construct(UsuarioRepository $usuarioseguridadrepository)
    {
        $this->usuario_seguridad_repository = $usuarioseguridadrepository;
    }

    public function restablecerPassword(array $datos): string
    {
        return Password::broker('users')->reset(
            $datos,
            function (Usuario $usuario, string $password) {

                $this->usuario_seguridad_repository->actualizarPassword(
                    $usuario,
                    $password,
                    Str::random(60)
                );

                event(new PasswordReset($usuario));
            }
        );
    }
}
