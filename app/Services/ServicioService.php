<?php

namespace App\Services;
use App\Models;
use App\Repository\ServicioRepository;

class ServicioService{

    private ServicioRepository $servicio_repository;

    public function __construct(ServicioRepository $serviciorepository)
    {
        $this->servicio_repository = $serviciorepository;
    }

    public function listarTodo(){
        return $this->servicio_repository->listarTodo();
    }
    
    public function store(array $datos)
    {
        $this->servicio_repository->store($datos);
    }

    public function edit(int $id)
    {
        return $this->servicio_repository->edit($id);
    }

    public function update(int $id, array $datos)
    {
        $this->servicio_repository->update($id, $datos);
    }

    public function destroy(int $id)
    {
        $this->servicio_repository->destroy($id);
    }
}