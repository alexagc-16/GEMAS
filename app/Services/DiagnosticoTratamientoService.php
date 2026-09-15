<?php

namespace App\Services;

use App\Repository\DiagnosticoTratamientoRepository;

class DiagnosticoTratamientoService{
   
    private DiagnosticoTratamientoRepository $diagnostico_tratamiento_repository;

    public function __construct(DiagnosticoTratamientoRepository $diagnosticotratamientorepository) {
        $this->diagnostico_tratamiento_repository = $diagnosticotratamientorepository;
    }

    public function listartodo(){
        return $this->diagnostico_tratamiento_repository->listartodo();
    }

    public function store(array $datos)
    {
        $this->diagnostico_tratamiento_repository->store($datos);
    }

    public function edit(int $id)
    {
        return $this->diagnostico_tratamiento_repository->edit($id);
    }

    public function update(int $id, array $datos)
    {
        $this->diagnostico_tratamiento_repository->update($id, $datos);
    }

    public function destroy(int $id)
    {
        $this->diagnostico_tratamiento_repository->destroy($id);
    }
}