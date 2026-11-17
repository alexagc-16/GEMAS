<?php

namespace App\Http\Controllers;

use App\Http\Requests\MascotaAdopcionStoreRequest;
use App\Models\MascotaAdopcion;
use App\Services\MascotaAdopcionService;

class MascotaAdopcionController extends Controller
{
    private MascotaAdopcionService $mascota_adopcion_service;

    public function __construct(MascotaAdopcionService $mascotaadopcionservice)
    {
        $this->mascota_adopcion_service = $mascotaadopcionservice;
    }

    // Mostrar todas las mascotas registradas.
    public function index()
    {
        $mascotas = $this->mascota_adopcion_service->index();

        return view('MascotaAdopcion.index', compact('mascotas'));
    }

    // Mostrar formulario de registro.
    public function create()
    {
        return view('MascotaAdopcion.create');
    }

    // Guardar una nueva mascota.
    public function store(MascotaAdopcionStoreRequest $request)
    {
        $datos = $request->validated();

        $this->mascota_adopcion_service->store($datos);

        return redirect()
            ->route('mascotasAdopcion.index')
            ->with('success', 'Mascota registrada correctamente.');
    }

    public function show(int $id)
    {
        $mascota = $this->mascota_adopcion_service->obtenerPorId($id);

        return view('MascotaAdopcion.index', compact('mascota'));
    }

    // Mostrar formulario de edición.
    public function edit(int $id)
    {
        $mascota = $this->mascota_adopcion_service->edit($id);

        return view('MascotaAdopcion.update', compact('mascota'));
    }

    // Actualizar una mascota.
    public function update(MascotaAdopcionStoreRequest $request, int $id)
    {
        $datos = $request->validated();

        $this->mascota_adopcion_service->update($id, $datos);

        return redirect()
            ->route('mascotasAdopcion.index')
            ->with('success', 'Mascota actualizada correctamente.');
    }

    // Mostrar únicamente las mascotas disponibles para adopción.
    public function catalogo()
    {
        $mascotas = $this->mascota_adopcion_service->listarEnAdopcion();

        return view('catalogo.index', compact('mascotas'));
    }
}

