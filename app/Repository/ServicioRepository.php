<?php

namespace App\Repository;
use App\Models;
use App\Models\Servicio;

class ServicioRepository{

    public function listarPaginado(int $porPagina = 10, array $filtros = [])
    {
        $consulta = Servicio::query();

        if (!empty($filtros['buscar'])) {
            $buscar = trim($filtros['buscar']);

            $consulta->where(function ($query) use ($buscar) {
                $query->where('nombre', 'LIKE', "%{$buscar}%")
                    ->orWhere('descripcion', 'LIKE', "%{$buscar}%");
            });
        }

        if (!empty($filtros['tiempo'])) {
            switch ($filtros['tiempo']) {
                case '30':
                    $consulta->where('duracionMinutos', '<=', 30);
                    break;

                case '60':
                    $consulta->whereBetween('duracionMinutos', [31, 60]);
                    break;

                case '120':
                    $consulta->whereBetween('duracionMinutos', [61, 120]);
                    break;

                case 'mas120':
                    $consulta->where('duracionMinutos', '>', 120);
                    break;
            }
        }

        return $consulta->latest()
            ->paginate($porPagina)
            ->withQueryString();
    }

    public function listarTodo(){
        return Servicio::all();
    }

    public function store(array $datos)
    {
        Servicio::create($datos);
    }

    public function edit(int $id)
    {
        return Servicio::findOrfail($id);
    }

    public function update(int $id, array $datos)
    {
        $servicio = Servicio::findOrfail($id);
        $servicio->update($datos);
    }

    public function destroy(int $id)
    {
        Servicio::destroy($id);
    }
}