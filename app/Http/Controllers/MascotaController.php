<?php

namespace App\Http\Controllers;

use App\Http\Requests\MascotaStoreRequest;
use App\Models\Mascota;
use App\Services\MascotaService;
use App\Services\UsuarioService;
use Illuminate\Http\Request;

class MascotaController extends Controller
{
    private MascotaService $mascota_service;
    private UsuarioService $usuario_service;

    public function __construct(MascotaService $mascotaservice, UsuarioService $usuarioservice)
    {
        $this->mascota_service = $mascotaservice;
        $this->usuario_service= $usuarioservice;
    }

    public function index()
    {
        $mascotas = $this->mascota_service->listartodo();
        return view('Mascota.index', compact('mascotas'));
        
    }
    
    public function create()
    {
        $usuarios = $this->usuario_service->listartodo();
        return view('Mascota.create', compact('usuarios'));
    }

    public function store(MascotaStoreRequest $request)
    {
        $this->mascota_service->store($request->validated());
        return redirect()->route('mascota.index')->with('sucess', 'Mascota creada correctamente');
    }

    public function show()
    {
        //
    }

    public function edit(int $id)
    {
        $mascota = $this->mascota_service->edit($id);
        $usuarios = $this->usuario_service->listartodo();
        return view('Mascota.update', compact('mascota', 'usuarios'));
    }

    public function update(int $id, MascotaStoreRequest $request)
    {
        $this->mascota_service->update($id, $request->all());
        return redirect()->route('mascota.index')->with('update', 'Mascota actualizada correctamente');
    }

    public function destroy(int $id)
    {
        $this->mascota_service->destroy($id);
        return redirect()->route('mascota.index')->with('destroy', 'Mascota eliminada correctamente');
    }
}
