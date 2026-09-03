<?php

namespace App\Services;

use App\Repository\UsuarioRepository;

class UsuarioService{

    private UsuarioRepository $usuario_repository;

    public function __construct(UsuarioRepository $usuariorepository) {
        $this->usuario_repository = $usuariorepository;
    }

    public function listartodo(){
        return $this->usuario_repository->listartodo();
    }

    public function store(array $datos)
    {
        $this->usuario_repository->store($datos);
    }

    public function edit(int $id)
    {
        return $this->usuario_repository->edit($id);
    }

    public function update(int $id, array $datos)
    {
        $this->usuario_repository->update($id, $datos);
    }

    public function destroy(int $id)
    {
        $this->usuario_repository->destroy($id);
    }

}