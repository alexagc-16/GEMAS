<?php

namespace App\Repository;
use App\Models\Mascota;

class MascotaRepository{

    public function listartodo(){
        return Mascota::with('Usuario')->get();
    }

    public function store(array $datos)
    {
        Mascota::create($datos);
    }

    public function edit(int $id)
    {
        return Mascota::findOrfail($id);
    }

    public function update(int $id, array $datos)
    {
        $mascota = Mascota::findOrfail($id);
        $mascota->update($datos);   
    }

    public function destroy(int $id)
    {
        Mascota::destroy($id);
    }
}