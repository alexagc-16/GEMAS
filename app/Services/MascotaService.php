<?php

namespace App\Services;

use App\Repository\MascotaRepository;

class MascotaService{

    private MascotaRepository $mascota_repository;

    public function __construct(MascotaRepository $mascotarepository)
    {
        $this->mascota_repository = $mascotarepository;
    }

    public function listartodo(){
        return $this->mascota_repository->listartodo();
    }

    public function store(array $datos)
    {
        $this->mascota_repository->store($datos);
    }

    public function edit(int $id)
    {
        return $this->mascota_repository->edit($id);;
    }

    public function update(int $id, array $datos)
    {
        $this->mascota_repository->update($id, $datos);  
    }

    public function destroy(int $id)
    {
        $this->mascota_repository->destroy($id);
    }

}