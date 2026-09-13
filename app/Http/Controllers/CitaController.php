<?php

namespace App\Http\Controllers;

use App\Http\Requests\CitaStoreRequest;
use App\Models\Cita;
use App\Services\CitaService;
use App\Services\MascotaService;
use App\Services\ServicioService;
use App\Services\VeterinarioService;
use Illuminate\Http\Request;

class CitaController extends Controller
{

    private CitaService $cita_service;
    private MascotaService $mascota_service;
    private VeterinarioService $veterinario_service;
    private ServicioService $servicio_service;

    public function __construct(CitaService $citaservice, MascotaService $mascotaservice, VeterinarioService $veterinarioservice, ServicioService $servicioservice) {
        $this->cita_service = $citaservice;
        $this->mascota_service = $mascotaservice;
        $this->veterinario_service = $veterinarioservice;
        $this->servicio_service = $servicioservice;
    }

    public function index()
    {
        $citas = $this->cita_service->listartodo();
        return view('Cita.index', compact('citas'));
    }

    public function create()
    {
        $mascotas = $this->mascota_service->listartodo();
        $veterinarios = $this->veterinario_service->listartodo();
        $servicios = $this->servicio_service->listarTodo();
        return view('Cita.create', compact('mascotas', 'veterinarios', 'servicios'));
    }

    public function store(CitaStoreRequest $request)
    {
        $this->cita_service->store($request->validated());
        return redirect()->route('cita.index')->with('success', 'Cita creada correctamente');
    }

    public function show()
    {
        //
    }

    public function edit(int $id)
    {
        $cita = $this->cita_service->edit($id);
        $mascotas = $this->mascota_service->listartodo();
        $veterinarios = $this->veterinario_service->listartodo();
        $servicios = $this->servicio_service->listarTodo();
        return view('Cita.update', compact('cita','mascotas', 'veterinarios', 'servicios'));
    }

    public function update(int $id, CitaStoreRequest $request)
    {
        $this->cita_service->update($id, $request->all());
        return redirect()->route('cita.index')->with('update', 'Cita actualizada correctamente');
    }

    public function destroy(int $id)
    {
        $this->cita_service->destroy($id);
        return redirect()->route('cita.index')->with('destroy', 'Cita eliminada correctamente');
    }
}
