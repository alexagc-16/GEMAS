<?php

namespace App\Repository;
use App\Models\Mascota;

class MascotaRepository{

    public function listarPaginado(int $porPagina = 10){
        return Mascota::latest()->paginate($porPagina);
    }

    public function listarPaginadoPorUsuario(int $idUsuario, int $porPagina = 10)
    {
        return Mascota::where('idUsuario', $idUsuario)
            ->latest()
            ->paginate($porPagina);
    }

    public function listarTodo(){
        return Mascota::with('Usuario')->get();
    }

    public function listarPorUsuario(int $idUsuario)
    {
        return Mascota::where('idUsuario', $idUsuario)->get();
    }

    public function buscarPorUsuario(int $id, int $idUsuario)
    {
        return Mascota::where('id', $id)
            ->where('idUsuario', $idUsuario)
            ->firstOrFail();
    }

    public function store(array $datos)
    {
        return Mascota::create($datos);
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