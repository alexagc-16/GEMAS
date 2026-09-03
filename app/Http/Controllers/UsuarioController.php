<?php

namespace App\Http\Controllers;

use App\Http\Requests\UsuarioStoreRequest;
use App\Models\Usuario;
use App\Services\UsuarioService;
use GrahamCampbell\ResultType\Success;
use Illuminate\Http\Request;

class UsuarioController extends Controller
{
    private UsuarioService $usuario_service;

    public function __construct(UsuarioService $usuarioservice)
    {
        $this->usuario_service = $usuarioservice;
    }
   
    public function index()
    {
        $usuarios = $this->usuario_service->listartodo();
        return view('Usuario.index', compact('usuarios'));
    }

    public function create()
    {
        return view('Usuario.create');
    }

    public function store(UsuarioStoreRequest $request)
    {
        $this->usuario_service->store($request->validated());
        return redirect()->route('usuario.index')->with('success', 'Usuario creado correctamente');
    }

    public function show()
    {
        //
    }

    public function edit(int $id)
    {
        $usuario = $this->usuario_service->edit($id);
        return view('Usuario.update', compact('usuario'));
    }

    public function update(int $id, UsuarioStoreRequest $request)
    {
        $this->usuario_service->update($id, $request->all());
        return redirect()->route('usuario.index')->with('update', 'Usuario actualizado correctamente');
    }

    public function destroy(int $id)
    {
        $this->usuario_service->destroy($id);

        return redirect()->route('usuario.index')->with('destroy', 'Usuario eliminado correctamente');
    }
}
