<?php

namespace App\Repository;
use App\Models\Usuario;

class UsuarioRepository{

    public function listarPaginado(int $porPagina = 10){
        return Usuario::latest()->paginate($porPagina);
    }

    public function listartodo(){
        return Usuario::all();
    }

    public function store(array $datos)
    {
        return Usuario::create($datos);
    }

    public function edit(int $id)
    {
        return Usuario::findOrfail($id);
    }

    public function update(int $id, array $datos)
    {
        $usuario = Usuario::findOrfail($id);
        $usuario->update($datos);   
    }

    public function destroy(int $id)
    {
        Usuario::destroy($id);
    }


}