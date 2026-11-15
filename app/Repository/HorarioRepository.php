<?php

namespace App\Repository;
use App\Models;
use App\Models\Horario;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Models\Role;

class HorarioRepository{

    public function listarPaginado(int $porPagina = 10, array $filtros = [])
    {
        $consulta = $this->consultaSegunUsuario();

        // Búsqueda general: día de la semana o nombre del veterinario.
        if (!empty($filtros['buscar'])) {

            $buscar = trim($filtros['buscar']);

            $consulta->where(function ($query) use ($buscar) {

                $query->where('diaSemana', 'LIKE', "%{$buscar}%")

                    ->orWhereHas('Veterinario', function ($subquery) use ($buscar) {

                        $subquery->where('nombre', 'LIKE', "%{$buscar}%");

                    });

            });
        }

        // Filtro por día de la semana.
        if (!empty($filtros['diaSemana'])) {

            $consulta->where('diaSemana', $filtros['diaSemana']);

        }

        // Filtro por veterinario.
        if (!empty($filtros['idVeterinario'])) {

            $consulta->where('idVeterinario', $filtros['idVeterinario']);

        }

        return $consulta->latest()
            ->paginate($porPagina)
            ->withQueryString();
    }

    public function listartodo()
    {
        return $this->consultaSegunUsuario()->get();
    }

    private function consultaSegunUsuario()
    {
        $usuario = Auth::user();

        $consulta = Horario::with('Veterinario');

        $esVeterinario = Role::where('name', 'veterinario')
            ->where('activo', true)
            ->whereHas('users', function ($query) use ($usuario) {
                $query->where('model_id', $usuario->id);
            })
            ->exists();

        if ($esVeterinario) {
            $consulta->whereHas('Veterinario', function ($query) use ($usuario) {
                $query->where(
                    'documentoIdentidad',
                    $usuario->documentoIdentidad
                );
            });
        }

        return $consulta;
    }

    public function store(array $datos)
    {
        Horario::create($datos);
    }

    public function edit(int $id)
    {
        return Horario::findOrfail($id);
    }

    public function update(int $id, array $datos)
    {
        $horario = Horario::findOrfail($id);
        $horario->update($datos);
    }

    public function destroy(int $id)
    {
        Horario::destroy($id);
    }
}