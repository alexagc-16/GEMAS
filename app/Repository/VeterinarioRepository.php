<?php

namespace App\Repository;
use App\Models;
use App\Models\Veterinario;

class VeterinarioRepository{

    public function listarPaginado(int $porPagina = 10, array $filtros = [])
    {
        $consulta = Veterinario::query();

        // Búsqueda general
        if (!empty($filtros['buscar'])) {
            $buscar = trim($filtros['buscar']);

            $consulta->where(function ($query) use ($buscar) {
                $query->where('nombre', 'like', "%{$buscar}%")
                    ->orWhere('apellido', 'like', "%{$buscar}%")
                    ->orWhere('documentoIdentidad', 'like', "%{$buscar}%")
                    ->orWhere('telefono', 'like', "%{$buscar}%")
                    ->orWhere('email', 'like', "%{$buscar}%")
                    ->orWhere('especialidad', 'like', "%{$buscar}%");
            });
        }

        // Filtro por especialidad
        if (!empty($filtros['especialidad'])) {
            $consulta->where('especialidad', $filtros['especialidad']);
        }

        return $consulta->latest()
            ->paginate($porPagina)
            ->withQueryString();
    }

    public function listarEspecialidades()
    {
        return Veterinario::query()
            ->whereNotNull('especialidad')
            ->where('especialidad', '!=', '')
            ->distinct()
            ->orderBy('especialidad')
            ->pluck('especialidad', 'especialidad');
    }
    
    public function listartodo(){
        return Veterinario::all();
    }
    
    public function store( array $datos)
    {
        return Veterinario::create($datos);
    }

    public function edit(int $id)
    {
        return Veterinario::findOrfail($id);
    }

    public function update(int $id, array $datos)
    {
        $veterinario = Veterinario::findOrfail($id);
        $veterinario->update($datos);

    }

}