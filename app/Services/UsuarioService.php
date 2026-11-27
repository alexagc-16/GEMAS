<?php

namespace App\Services;

use App\Repository\UsuarioRepository;
use App\Repository\Seguridad\UsuarioRepository as UsuarioSeguridadRepository;
use Illuminate\Support\Facades\DB;

class UsuarioService{

    private UsuarioRepository $usuario_repository;
    private UsuarioSeguridadRepository $usuario_seguridad_repository;

    public function __construct(UsuarioRepository $usuariorepository, UsuarioSeguridadRepository $usuarioseguridadrepository) {
        $this->usuario_repository = $usuariorepository;
        $this->usuario_seguridad_repository = $usuarioseguridadrepository;
    }

    public function listarPaginado(int $porPagina = 10, array $filtros = [])
    {
        return $this->usuario_repository->listarPaginado($porPagina, $filtros);
    }

    public function listarActivosPorRol(string $rol)
    {
        return $this->usuario_repository->listarActivosPorRol($rol);
    }

    public function listartodo(){
        return $this->usuario_repository->listartodo();
    }

    public function store(array $datos)
    {
        return DB::transaction(function () use ($datos) {

            // Encripta la contraseña antes de guardar
            $datos['password'] = bcrypt($datos['password']);

            // Crea el usuario
            $usuario = $this->usuario_repository->store($datos);

            // Asigna automáticamente el rol usuario
            $this->usuario_seguridad_repository->sincronizarRoles(
                $usuario,
                ['usuario']
            );

            return $usuario;
        });
    }
    
    public function edit(int $id)
    {
        return $this->usuario_repository->edit($id);
    }

    public function update(int $id, array $datos)
    {
        $this->usuario_repository->update($id, $datos);
    }

}