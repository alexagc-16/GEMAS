<?php

namespace App\Services;

use App\Repository\HorarioRepository;

class HorarioService{

    private HorarioRepository $horario_repository;

    public function __construct(HorarioRepository $horariorepository) {
        $this->horario_repository = $horariorepository;
    }

    public function listartodo(){
        return $this->horario_repository->listartodo();
    }
    
    public function store(array $datos)
    {
        $this->horario_repository->store($datos);
    }

    public function edit(int $id)
    {
        return $this->horario_repository->edit($id);
    }

    public function update(int $id, array $datos)
    {
        $this->horario_repository->update($id, $datos);
    }

    public function destroy(int $id)
    {
        $this->horario_repository->destroy($id);
    }
}