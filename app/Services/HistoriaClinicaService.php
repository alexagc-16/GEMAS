<?php

namespace App\Services;

use App\Repository\HistoriaClinicaRepository;

class HistoriaClinicaService{

    private HistoriaClinicaRepository $historia_clinica_repository;

    public function __construct(HistoriaClinicaRepository $historiaclinicarepository)
    {
        $this->historia_clinica_repository = $historiaclinicarepository;
    }

     public function listartodo(){
        return $this->historia_clinica_repository->listartodo();
    }

    public function store(array $datos)
    {
        $this->historia_clinica_repository->store($datos);
    }

    public function edit(int $id)
    {
        return $this->historia_clinica_repository->edit($id);;
    }

    public function update(int $id, array $datos)
    {
        $this->historia_clinica_repository->update($id, $datos);  
    }

    public function destroy(int $id)
    {
        $this->historia_clinica_repository->destroy($id);
    }

}