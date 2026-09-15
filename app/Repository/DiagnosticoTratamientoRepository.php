<?php

namespace App\Repository;
use App\Models;
use App\Models\DiagnosticoTratamiento;

class DiagnosticoTratamientoRepository{

    public function listartodo(){
        return DiagnosticoTratamiento::with('Evolucion')->get();
    }

    public function store(array $datos)
    {
        DiagnosticoTratamiento::create($datos);
    }

    public function edit(int $id)
    {
        return DiagnosticoTratamiento::findOrfail($id);
    }

    public function update(int $id, array $datos)
    {
        $diagnosticoTratamiento = DiagnosticoTratamiento::findOrfail($id);
        $diagnosticoTratamiento->update($datos);
    }

    public function destroy(int $id)
    {
        DiagnosticoTratamiento::destroy($id);
    }
}