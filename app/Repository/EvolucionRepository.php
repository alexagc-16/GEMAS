<?php

namespace App\Repository;
use App\Models;
use App\Models\Evolucion;

class EvolucionRepository{

    public function listartodo(){
        return Evolucion::with('HistoriaClinica', 'Veterinario')->get();
    }

    public function store(array $datos)
    {
        Evolucion::create($datos);
    }

    public function edit(int $id)
    {
        return Evolucion::findOrfail($id);
    }

    public function update(int $id, array $datos)
    {
        $evolucion = Evolucion::findOrfail($id);
        $evolucion->update($datos);
    }

    public function destroy(int $id)
    {
        Evolucion::destroy($id);
    }
}