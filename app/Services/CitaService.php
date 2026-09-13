<?php

namespace App\Services;

use App\Repository\CitaRepository;

class CitaService {

    private CitaRepository $cita_repository;

    public function __construct(CitaRepository $citarepository) {
        $this->cita_repository = $citarepository;
    }

    public function listartodo(){
        return $this->cita_repository->listartodo();
    }

    public function store(array $datos)
    {
        $this->cita_repository->store($datos);
    }

    public function edit(int $id)
    {
        return $this->cita_repository->edit($id);
    }

    public function update(int $id,array $datos)
    {
        $this->cita_repository->update($id, $datos);
    }

    public function destroy(int $id)
    {
        $this->cita_repository->destroy($id);
    }
}