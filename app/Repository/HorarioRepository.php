<?php

namespace App\Repository;
use App\Models;
use App\Models\Horario;

class HorarioRepository{

    public function listartodo(){
        return Horario::with('Veterinario')->get();
    }

    public function store(array $datos)
    {
        Horario::create($datos);
    }

    public function edit(int $id)
    {
        return Horario::findOrfail($id);
    }

    public function update(int $id, array $datos)
    {
        $horario = Horario::findOrfail($id);
        $horario->update($datos);
    }

    public function destroy(int $id)
    {
        Horario::destroy($id);
    }
}