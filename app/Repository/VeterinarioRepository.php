<?php

namespace App\Repository;
use App\Models;
use App\Models\Veterinario;

class VeterinarioRepository{
    
    public function listartodo(){
        return Veterinario::all();
    }
    
    public function store( array $datos)
    {
        Veterinario::create($datos);
    }

    public function edit(int $id)
    {
        return Veterinario::findOrfail($id);
    }

    public function update(int $id, array $datos)
    {
        $veterinario = Veterinario::findOrfail($id);
        $veterinario->update($datos);

    }

    public function destroy(int $id)
    {
        Veterinario::destroy($id);
    }

}