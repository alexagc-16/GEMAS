<?php

namespace App\Http\Controllers;

use App\Http\Requests\MascotaStoreRequest;
use App\Models\Mascota;
use App\Models\Usuario;
use App\Services\MascotaService;
use App\Services\UsuarioService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
        /** @var Usuario $usuario */
        $usuario = Auth::user();

        if ($usuario->tieneRolActivo('usuario')) {
            $mascotas = $this->mascota_service->listarPaginadoPorUsuario($usuario->id, 10);
        } else {
            $mascotas = $this->mascota_service->listarPaginado(10);
        }

        return view('Mascota.index', compact('mascotas'));
    }
    
    public function create()
    {
        $usuarios = $this->usuario_service->listartodo();
        return view('Mascota.create', compact('usuarios'));
    }

    public function store(MascotaStoreRequest $request)
    {
        $this->mascota_service->store(
            $request->safe()->except('imagen'),
            $request->file('imagen')
        );

        return redirect()->route('mascota.index')->with('success', 'Mascota creada correctamente');
    }

    public function show()
    {
        //
    }

    public function edit(int $id)
    {
        /** @var Usuario $usuario */
        $usuario = Auth::user();

        if ($usuario->tieneRolActivo('usuario')) {
            $mascota = $this->mascota_service->buscarPorUsuario($id, $usuario->id);
        } else {
            $mascota = $this->mascota_service->edit($id);
        }

        $usuarios = $this->usuario_service->listartodo();

        return view('Mascota.update', compact('mascota', 'usuarios'));
    }

    public function update(int $id, MascotaStoreRequest $request)
    {
        /** @var Usuario $usuario */
        $usuario = Auth::user();

        if ($usuario->tieneRolActivo('usuario')) {

            // Comprobar que la mascota pertenece al usuario.
            $this->mascota_service->buscarPorUsuario($id, $usuario->id);

            // El usuario solo puede actualizar la fotografía.
            $datos = $request->safe()->only(['eliminar_imagen']);

        } else {

            // Los demás roles conservan la edición completa.
            $datos = $request->safe()->except('imagen');
            $datos['eliminar_imagen'] = $request->input('eliminar_imagen', '0');
        }

        $this->mascota_service->update(
            $id,
            $datos,
            $request->file('imagen')
        );

        return redirect()
            ->route('mascota.index')
            ->with('update', 'Mascota actualizada correctamente');
    }

    public function destroy(int $id)
    {
        $this->mascota_service->destroy($id);
        return redirect()->route('mascota.index')->with('destroy', 'Mascota eliminada correctamente');
    }
}
