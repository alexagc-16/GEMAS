<?php

namespace App\Repository;
use App\Models\Usuario;

class UsuarioRepository{

    public function listarPaginado(int $porPagina = 10, array $filtros = [])
    {
        $consulta = Usuario::with('roles');

        // Buscar por nombre, apellido, documento, teléfono,
        // correo electrónico o dirección.
        if (!empty($filtros['buscar'])) {
            $buscar = trim($filtros['buscar']);

            $consulta->where(function ($query) use ($buscar) {
                $query->where('nombre', 'like', "%{$buscar}%")
                    ->orWhere('apellido', 'like', "%{$buscar}%")
                    ->orWhere('documentoIdentidad', 'like', "%{$buscar}%")
                    ->orWhere('telefono', 'like', "%{$buscar}%")
                    ->orWhere('email', 'like', "%{$buscar}%")
                    ->orWhere('direccion', 'like', "%{$buscar}%");
            });
        }

        // Filtrar por rol.
        if (!empty($filtros['rol'])) {
            $consulta->whereHas('roles', function ($query) use ($filtros) {
                $query->where('name', $filtros['rol']);
            });
        }

        return $consulta
            ->latest()
            ->paginate($porPagina)
            ->withQueryString();
    }

    public function listarActivosPorRol(string $rol)
    {
        return Usuario::whereNull('cuentaDesactivadaEn')
            ->whereHas('roles', function ($query) use ($rol) {
                $query->where('name', $rol);
            })
            ->orderBy('nombre')
            ->get();
    }

    public function listartodo(){
        return Usuario::all();
    }

    public function store(array $datos)
    {
        return Usuario::create($datos);
    }

    public function edit(int $id)
    {
        return Usuario::findOrfail($id);
    }

    public function update(int $id, array $datos)
    {
        $usuario = Usuario::findOrfail($id);
        $usuario->update($datos);   
    }


}