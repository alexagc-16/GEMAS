<?php

namespace App\Repository;
use App\Models;
use App\Models\Servicio;

class ServicioRepository{

    public function listarPaginado(int $porPagina = 10){
        return Servicio::latest()->paginate($porPagina);
    }

    public function listarTodo(){
        return Servicio::all();
    }

    public function store(array $datos)
    {
        Servicio::create($datos);
    }

    public function edit(int $id)
    {
        return Servicio::findOrfail($id);
    }

    public function update(int $id, array $datos)
    {
        $servicio = Servicio::findOrfail($id);
        $servicio->update($datos);
    }

    public function destroy(int $id)
    {
        Servicio::destroy($id);
    }
}