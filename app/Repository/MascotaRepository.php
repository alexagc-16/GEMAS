<?php

namespace App\Repository;
use App\Models\Mascota;

class MascotaRepository{

    public function listarPaginado(int $porPagina = 10, array $filtros = [])
    {
        return $this->aplicarFiltros(
            Mascota::with('Usuario'),
            $filtros
        )
            ->latest()
            ->paginate($porPagina)
            ->withQueryString();
    }

    public function listarPaginadoPorUsuario(
        int $idUsuario,
        int $porPagina = 10,
        array $filtros = []
    ) {
        return $this->aplicarFiltros(
            Mascota::with('Usuario')->where('idUsuario', $idUsuario),
            $filtros
        )
            ->latest()
            ->paginate($porPagina)
            ->withQueryString();
    }

    /**
     * Aplicar los filtros de búsqueda a la consulta de mascotas.
     */
    private function aplicarFiltros($query, array $filtros)
    {
        return $query
            ->when(!empty($filtros['buscar']), function ($query) use ($filtros) {
                $buscar = trim($filtros['buscar']);

                $query->where(function ($subQuery) use ($buscar) {
                    $subQuery
                        ->where('nombre', 'like', "%{$buscar}%")
                        ->orWhere('raza', 'like', "%{$buscar}%")
                        ->orWhere('especie', 'like', "%{$buscar}%")
                        ->orWhereHas('Usuario', function ($usuarioQuery) use ($buscar) {
                            $usuarioQuery->where('nombre', 'like', "%{$buscar}%");
                        });
                });
            })
            ->when(!empty($filtros['especie']), function ($query) use ($filtros) {
                $query->where('especie', $filtros['especie']);
            })
            ->when(!empty($filtros['sexo']), function ($query) use ($filtros) {
                $query->where('sexo', $filtros['sexo']);
            });
    }

    /**
     * Obtener las especies registradas para el filtro.
     */
    public function listarEspecies()
    {
        return Mascota::query()
            ->whereNotNull('especie')
            ->where('especie', '!=', '')
            ->distinct()
            ->orderBy('especie')
            ->pluck('especie');
    }

    public function listarTodo(){
        return Mascota::with('Usuario')->get();
    }

    public function listarPorUsuario(int $idUsuario)
    {
        return Mascota::where('idUsuario', $idUsuario)->get();
    }

    public function buscarPorUsuario(int $id, int $idUsuario)
    {
        return Mascota::where('id', $id)
            ->where('idUsuario', $idUsuario)
            ->firstOrFail();
    }

    public function store(array $datos)
    {
        return Mascota::create($datos);
    }

    public function edit(int $id)
    {
        return Mascota::findOrfail($id);
    }

    public function update(int $id, array $datos)
    {
        $mascota = Mascota::findOrfail($id);
        $mascota->update($datos);   
    }

    public function destroy(int $id)
    {
        Mascota::destroy($id);
    }
}