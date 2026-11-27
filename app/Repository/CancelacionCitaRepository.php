<?php

namespace App\Repository;

use App\Models\CancelacionCita;

class CancelacionCitaRepository{

    public function listartodo(){
        return CancelacionCita::with('Cita')
            ->orderBy('fechaCancelacion', 'desc')
            ->get();
    }

    public function store(array $datos)
    {
        return CancelacionCita::create($datos);
    }

    public function edit(int $id)
    {
        return CancelacionCita::findOrfail($id);
    }

    /*public function update(int $id, array $datos)
    {
        $cancelacionCita = CancelacionCita::findOrfail($id);
        $cancelacionCita->update($datos);
    }

    public function destroy(int $id)
    {
        CancelacionCita::destroy($id);
    }*/
}