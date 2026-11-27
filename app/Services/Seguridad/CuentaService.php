<?php

namespace App\Services\Seguridad;

use App\Repository\Seguridad\RolRepository;
use App\Repository\Seguridad\UsuarioRepository;
use Exception;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\PermissionRegistrar;
use App\Models\Usuario;

class CuentaService
{
    public function __construct(
        private UsuarioRepository $usuarioRepository,
        private RolRepository $rolRepository,
    ) {
    }

    public function listar(): Collection
    {
        return $this->usuarioRepository->listarConRoles();
    }

    public function listarRoles(): Collection
    {
        return $this->rolRepository->listar();
    }

    public function buscar(int|string $id): Usuario
    {
        return Usuario::with('rolesConInactivos')->findOrFail($id);
    }

    public function crear(array $datos, array $roles): void
    {
        $datos['password'] = Hash::make($datos['password']);

        DB::transaction(function () use ($datos, $roles): void {
            $usuario = $this->usuarioRepository->crear($datos);
            $this->usuarioRepository->sincronizarRoles($usuario, $roles);
        });

        $this->limpiarCache();
    }

    public function actualizar(Usuario $usuario, array $datos, array $roles, Usuario $actual): void
    {
        $rolAdmin = config('seguridad.rol_admin');

        $seQuitaSuRolAdmin = $usuario->is($actual)
            && $usuario->rolesConInactivos->contains('name', $rolAdmin)
            && ! in_array($rolAdmin, $roles, true);

        if ($seQuitaSuRolAdmin) {
            throw new Exception('No puedes quitarte tu propio rol de ' . $rolAdmin . '.');
        }

        if (empty($datos['password'])) {
            unset($datos['password']);
        } else {
            $datos['password'] = Hash::make($datos['password']);
        }

        DB::transaction(function () use ($usuario, $datos, $roles): void {
            $this->usuarioRepository->actualizar($usuario, $datos);
            $this->usuarioRepository->sincronizarRoles($usuario, $roles);
        });

        $this->limpiarCache();
    }

    /**
     * Desactiva una cuenta de usuario.
     */
    public function desactivar(Authenticatable $usuario, Authenticatable $actual): void
    {
        if (!$usuario instanceof Usuario || !$actual instanceof Usuario) {
            throw new Exception('No se pudo identificar la cuenta.');
        }

        $usuario->loadMissing('rolesConInactivos');
        $actual->loadMissing('rolesConInactivos');

        $rolesNoDesactivables = config('seguridad.roles_no_desactivables', []);

        if ($usuario->rolesConInactivos->whereIn('name', $rolesNoDesactivables)->isNotEmpty()) {
            throw new Exception('No está permitido desactivar esta cuenta.');
        }

        $esAdministrador = $actual->rolesConInactivos->contains('name', config('seguridad.rol_admin'));

        $esPropietario = $usuario->rolesConInactivos->contains('name', 'usuario');
        $esVeterinario = $usuario->rolesConInactivos->contains('name', 'veterinario');

        if (!$esPropietario && !$esVeterinario) {
            throw new Exception('Esta cuenta no puede desactivarse.');
        }

        if (!$esAdministrador) {
            if (!$usuario->is($actual) || !$esPropietario) {
                throw new Exception('No tienes autorización para desactivar esta cuenta.');
            }
        }

        if ($usuario->cuentaDesactivadaEn !== null) {
            throw new Exception('Esta cuenta ya se encuentra desactivada.');
        }

        $this->usuarioRepository->desactivar($usuario);
    }

    /**
     * Reactiva una cuenta de usuario.
     */
    public function reactivar(Authenticatable $usuario, Authenticatable $actual): void
    {
        if (!$usuario instanceof Usuario || !$actual instanceof Usuario) {
            throw new Exception('No se pudo identificar la cuenta.');
        }

        $actual->loadMissing('rolesConInactivos');
        $usuario->loadMissing('rolesConInactivos');

        $esAdministrador = $actual->rolesConInactivos->contains(
            'name',
            config('seguridad.rol_admin')
        );

        if (!$esAdministrador) {
            throw new Exception('Solo el administrador puede reactivar cuentas desde esta operación.');
        }

        $rolesNoDesactivables = config('seguridad.roles_no_desactivables', []);

        if ($usuario->rolesConInactivos->whereIn('name', $rolesNoDesactivables)->isNotEmpty()) {
            throw new Exception('Esta cuenta no puede reactivarse mediante este proceso.');
        }

        $esPropietario = $usuario->rolesConInactivos->contains('name', 'usuario');
        $esVeterinario = $usuario->rolesConInactivos->contains('name', 'veterinario');

        if (!$esPropietario && !$esVeterinario) {
            throw new Exception('Esta cuenta no puede reactivarse.');
        }

        if ($usuario->cuentaDesactivadaEn === null) {
            throw new Exception('Esta cuenta no se encuentra desactivada.');
        }

        if ($usuario->cuentaDesactivadaEn->lte(now()->subDays(7))) {
            throw new Exception('El plazo de recuperación de esta cuenta ha finalizado.');
        }

        $this->usuarioRepository->reactivar($usuario);
    }

    private function limpiarCache(): void
    {
        app(PermissionRegistrar::class)->forgetCachedPermissions();
    }
}
