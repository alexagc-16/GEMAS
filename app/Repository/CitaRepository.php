<?php

namespace App\Repository;
use App\Models;
use App\Models\Cita;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Models\Role;

class CitaRepository {

    public function listarPaginado(int $porPagina = 10)
    {
        return $this->consultaSegunUsuario()
            ->with(['Mascota', 'Veterinario', 'Servicio', 'CancelacionCita'])
            ->latest()
            ->paginate($porPagina);
    }

    public function listartodo()
    {
        return $this->consultaSegunUsuario()
            ->with(['Mascota', 'Veterinario', 'Servicio', 'CancelacionCita'])
            ->get();
    }

    public function store(array $datos)
    {
        Cita::create($datos);
    }

    public function edit(int $id)
    {
        return $this->consultaSegunUsuario()
        ->with(['Mascota', 'Veterinario', 'Servicio', 'CancelacionCita'])
        ->findOrFail($id);
    }

    public function update(int $id, array $datos)
    {
        $cita = $this->edit($id);
        $cita->update($datos);
    }

    public function destroy(int $id)
    {
        Cita::destroy($id);
    }

    private function consultaSegunUsuario()
    {
        $usuario = Auth::user();

        $consulta = Cita::query();

        if (!$usuario) {
            return $consulta->whereRaw('1 = 0');
        }

        // Comprobar si es administrador.
        $esAdministrador = Role::where('name', 'administrador')
            ->where('activo', true)
            ->whereHas('users', function ($query) use ($usuario) {
                $query->where('model_id', $usuario->id);
            })
            ->exists();

        if ($esAdministrador) {
            return $consulta;
        }

        // Comprobar si es veterinario.
        $esVeterinario = Role::where('name', 'veterinario')
            ->where('activo', true)
            ->whereHas('users', function ($query) use ($usuario) {
                $query->where('model_id', $usuario->id);
            })
            ->exists();

        if ($esVeterinario) {
            return $consulta->whereHas('Veterinario', function ($query) use ($usuario) {
                $query->where(
                    'documentoIdentidad',
                    $usuario->documentoIdentidad
                );
            });
        }

        // Comprobar si es propietario de mascotas.
        $esUsuario = Role::where('name', 'usuario')
            ->where('activo', true)
            ->whereHas('users', function ($query) use ($usuario) {
                $query->where('model_id', $usuario->id);
            })
            ->exists();

        if ($esUsuario) {
            return $consulta->whereHas('Mascota', function ($query) use ($usuario) {
                $query->where('idUsuario', $usuario->id);
            });
        }

        // Si no tiene un rol autorizado, no devuelve citas.
        return $consulta->whereRaw('1 = 0');
    }
}