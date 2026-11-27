<?php

namespace App\Services\Seguridad;

use App\Repository\Seguridad\UsuarioRepository;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\Usuario;

class AuthService
{
    public function __construct(private UsuarioRepository $usuariorepository)
    {
    }

    public function autenticar(string $email, string $password, bool $recordar = false): bool
    {
        $usuario = $this->usuariorepository->buscarPorEmail($email);

        if (
            !$usuario instanceof Usuario ||
            !Hash::check($password, $usuario->getAuthPassword())
        ) {
            return false;
        }

        // Comprobar si la cuenta está desactivada.
        if ($usuario->cuentaDesactivadaEn !== null) {

            $usuario->loadMissing('rolesConInactivos');

            $rolesNoDesactivables = config('seguridad.roles_no_desactivables', []);

            // Las cuentas protegidas no se recuperan mediante el inicio de sesión.
            if ($usuario->rolesConInactivos->whereIn('name', $rolesNoDesactivables)->isNotEmpty()) {
                return false;
            }

            $esPropietario = $usuario->rolesConInactivos->contains('name', 'usuario');

            // Solamente el propietario puede recuperar su cuenta iniciando sesión.
            if (!$esPropietario) {
                return false;
            }

            // Comprobar que todavía esté dentro del plazo de recuperación.
            if ($usuario->cuentaDesactivadaEn->lte(now()->subDays(7))) {
                return false;
            }

            // Reactivar la cuenta del propietario.
            $this->usuariorepository->reactivar($usuario);
        }

        Auth::guard(config('seguridad.guard'))->login($usuario, $recordar);

        return true;
    }

    public function cerrarSesion(): void
    {
        Auth::guard(config('seguridad.guard'))->logout();
    }
}
