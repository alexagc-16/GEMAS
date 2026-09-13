<?php

namespace App\Repository;
use App\Models;
use App\Models\Cita;

class CitaRepository {

    public function listartodo(){
        return Cita::with('Mascota', 'Veterinario', 'Servicio')->get()
        ;
    }

    public function store(array $datos)
    {
        Cita::create($datos);
    }

    public function edit(int $id)
    {
        return Cita::findOrfail($id);
    }

    public function update(int $id, array $datos)
    {
        $cita = Cita::findOrfail($id);
        $cita->update($datos);
    }

    public function destroy(int $id)
    {
        Cita::destroy($id);
    }
}