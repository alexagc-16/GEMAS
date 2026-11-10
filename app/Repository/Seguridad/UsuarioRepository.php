<?php

namespace App\Repository\Seguridad;

use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Collection;
use Spatie\Permission\Models\Role;
use Illuminate\Database\Eloquent\Model;
use App\Models\Usuario;

class UsuarioRepository
{
    private function modelo(): string
    {
        return config('auth.providers.users.model');
    }

    public function buscarPorEmail(string $email): ?Authenticatable
    {
        return $this->modelo()::where('email', $email)->first();
    }

    public function buscarPorId(int|string $id): Authenticatable
    {
        return $this->modelo()::findOrFail($id);
    }

    public function buscarPorDocumento(string $documento): ?Authenticatable
    {
        return $this->modelo()::where('documentoIdentidad', $documento)->first();
    }

    public function crear(array $datos): Authenticatable
    {
        return $this->modelo()::create($datos);
    }

    /**
     * @param Authenticatable&Model $usuario
     */
    public function actualizar(Authenticatable $usuario, array $datos): Authenticatable
    {
        $usuario->update($datos);

        return $usuario;
    }

    /**
     * @param Authenticatable&Model $usuario
     */
    public function actualizarPassword(
        Authenticatable $usuario,
        string $password,
        string $rememberToken
    ): void {
        $usuario->forceFill([
            'password' => $password,
            'remember_token' => $rememberToken,
        ])->save();
    }

    public function contarConRol(string $rol): int
    {
        return $this->modelo()::whereHas('rolesConInactivos', function ($consulta) use ($rol) {
            $consulta->where(config('permission.table_names.roles') . '.name', $rol);
        })->count();
    }

    public function listarConRoles(): Collection
    {
        return $this->modelo()::with('rolesConInactivos')->orderBy('nombre')->get();
    }

    /**
     * @param Authenticatable&Model $usuario
     */
    public function sincronizarRoles(Authenticatable $usuario, array $nombresDeRoles): void
    {
        $ids = Role::whereIn('name', $nombresDeRoles)
            ->where('guard_name', config('seguridad.guard'))
            ->pluck('id')
            ->all();

        $usuario->rolesConInactivos()->sync($ids);
        $usuario->unsetRelation('roles');
    }

    /**
     * Desactiva una cuenta de usuario.
     */
    public function desactivar(Usuario $usuario): void
    {
        $usuario->forceFill([
            'cuentaDesactivadaEn' => now(),
        ])->save();
    }

    /**
     * Reactiva una cuenta de usuario.
     */
    public function reactivar(Usuario $usuario): void
    {
        $usuario->forceFill([
            'cuentaDesactivadaEn' => null,
        ])->save();
    }
}
