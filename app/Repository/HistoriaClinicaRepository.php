<?php

namespace App\Repository;
use App\Models\HistoriaClinica;

class HistoriaClinicaRepository{

    public function listartodo(){
        return HistoriaClinica::with('Mascota')->get();
    }

    public function store(array $datos)
    {
        HistoriaClinica::create($datos);
    }

    public function edit(int $id)
    {
        return HistoriaClinica::findOrfail($id);
    }

    public function update(int $id, array $datos)
    {
        $historiaClinica = HistoriaClinica::findOrfail($id);
        $historiaClinica->update($datos);   
    }

    public function destroy(int $id)
    {
        HistoriaClinica::destroy($id);
    }

}