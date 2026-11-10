<?php

namespace App\Services\Seguridad;

use App\Repository\Seguridad\PermisoRepository;
use App\Repository\Seguridad\RolRepository;
use Exception;
use Illuminate\Database\Eloquent\Collection;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\PermissionRegistrar;
use Spatie\Permission\Models\Role;

class PermisoService
{
    public function __construct(
        private PermisoRepository $permisoRepository,
        private RolRepository $rolRepository,
    ) {
    }

    public function listar(): Collection
    {
        return $this->permisoRepository->listar();
    }

    public function listarModulos(): array
    {
        return $this->permisoRepository->listarModulos();
    }

    public function crear(string $nombre, ?string $modulo): void
    {
        $permiso = $this->permisoRepository->crear($nombre, $this->normalizarModulo($modulo));

        $this->darPermisoAlAdministrador([$permiso]);
        $this->asignarPermisoEspecial($permiso);
        $this->limpiarCache();
    }

    public function crearModulo(string $modulo): int
    {
        $modulo = $this->normalizarModulo($modulo);

        $permisos = [];

        foreach (config('seguridad.acciones') as $accion) {
            $permisos[] = $this->permisoRepository->crearSiNoExiste(
                $accion . ' ' . $modulo,
                $modulo
            );
        }

        $this->darPermisoAlAdministrador($permisos);

        $this->asignarPermisosPorRol($modulo);

        $this->limpiarCache();

        return count($permisos);
    }

    private function asignarPermisosPorRol(string $modulo): void
    {
        $permisosPorRol = config('seguridad.permisos_por_rol', []);

        foreach ($permisosPorRol as $nombreRol => $modulos) {

            if ($nombreRol === config('seguridad.rol_admin')) {
                continue;
            }

            $acciones = $modulos[$modulo] ?? [];

            if (empty($acciones)) {
                continue;
            }

            $permisos = [];

            foreach ($acciones as $accion) {
                $nombrePermiso = $accion . ' ' . $modulo;

                $permiso = $this->permisoRepository->crearSiNoExiste(
                    $nombrePermiso,
                    $modulo
                );

                $permisos[] = $permiso;
            }

            $rol = Role::findByName($nombreRol, config('seguridad.guard'));

            $rol->givePermissionTo($permisos);
        }
    }

    private function asignarPermisoEspecial(Permission $permiso): void
    {
        $permisosPorRol = config('seguridad.permisos_especiales_por_rol', []);

        foreach ($permisosPorRol as $nombreRol => $permisos) {

            if (! in_array($permiso->name, $permisos, true)) {
                continue;
            }

            $rol = Role::findByName($nombreRol, config('seguridad.guard'));

            $rol->givePermissionTo($permiso);
        }

        $this->limpiarCache();
    }

    public function actualizar(Permission $permiso, string $nombre, ?string $modulo): void
    {
        if ($permiso->name === config('seguridad.permiso_admin') && $nombre !== $permiso->name) {
            throw new Exception('El permiso "' . $permiso->name . '" no se puede renombrar.');
        }

        $this->permisoRepository->actualizar($permiso, $nombre, $this->normalizarModulo($modulo));
        $this->limpiarCache();
    }

    public function eliminar(Permission $permiso): void
    {
        if ($permiso->name === config('seguridad.permiso_admin')) {
            throw new Exception('El permiso "' . $permiso->name . '" no se puede eliminar.');
        }

        $this->permisoRepository->eliminar($permiso);
        $this->limpiarCache();
    }

    private function normalizarModulo(?string $modulo): ?string
    {
        $modulo = $modulo === null ? '' : trim($modulo);

        return $modulo === '' ? null : mb_strtolower($modulo);
    }

    private function darPermisoAlAdministrador(array $permisos): void
    {
        $administrador = $this->rolRepository->buscarPorNombre(config('seguridad.rol_admin'));

        $administrador?->givePermissionTo($permisos);
    }

    private function limpiarCache(): void
    {
        app(PermissionRegistrar::class)->forgetCachedPermissions();
    }
}
