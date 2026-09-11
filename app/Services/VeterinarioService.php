<?php

namespace App\Services;

use App\Repository\VeterinarioRepository;

class VeterinarioService{

    private VeterinarioRepository $veterinario_repository;
    public function __construct(VeterinarioRepository $veterinariorepository)
    {
        $this->veterinario_repository = $veterinariorepository;
    }

    public function listartodo(){
        return $this->veterinario_repository->listartodo();
    }
    
    public function store(array $datos)
    {
        $this->veterinario_repository->store($datos);
    }

    public function edit(int $id)
    {
        return $this->veterinario_repository->edit($id);
    }

    public function update(int $id, array $datos)
    {
        $this->veterinario_repository->update($id, $datos);
    }

    public function destroy(int $id)
    {
        $this->veterinario_repository->destroy($id);
    }    
}