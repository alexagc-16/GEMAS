<?php

namespace App\Services;

use App\Repository\EvolucionRepository;

class EvolucionService{

    private EvolucionRepository $evolucion_repository;

    public function __construct(EvolucionRepository $evolucionrepository) {
        $this->evolucion_repository = $evolucionrepository;
    }

    public function listartodo(){
        return $this->evolucion_repository->listartodo();
    }

    public function store(array $datos)
    {
        $this->evolucion_repository->store($datos);
    }

    public function edit(int $id)
    {
        return $this->evolucion_repository->edit($id);
    }

    public function update(int $id, array $datos)
    {
        $this->evolucion_repository->update($id, $datos);
    }

    public function destroy(int $id)
    {
        $this->evolucion_repository->destroy($id);
    }
}