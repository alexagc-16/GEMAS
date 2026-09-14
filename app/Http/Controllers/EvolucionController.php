<?php

namespace App\Http\Controllers;

use App\Http\Requests\EvolucionStoreRequest;
use App\Models\Evolucion;
use App\Services\EvolucionService;
use App\Services\HistoriaClinicaService;
use App\Services\VeterinarioService;
use Illuminate\Http\Request;

class EvolucionController extends Controller
{
    private EvolucionService $evolucion_service;
    private HistoriaClinicaService $historia_clinica_service;
    private VeterinarioService $veterinario_service;

    public function __construct(EvolucionService $evolucionservice, private HistoriaClinicaService $historiaclinicaservice, VeterinarioService $veterinarioservice) {
        $this->evolucion_service = $evolucionservice;
        $this->historia_clinica_service = $historiaclinicaservice;
        $this->veterinario_service = $veterinarioservice;
    }

    public function index()
    {
        $evoluciones = $this->evolucion_service->listartodo();
        return view('Evolucion.index', compact('evoluciones'));
    }

    public function create()
    {
        $historiasClinicas = $this->historia_clinica_service->listartodo();
        $veterinarios = $this->veterinario_service->listartodo();
        return view('Evolucion.create', compact('historiasClinicas', 'veterinarios'));
    }

    public function store(EvolucionStoreRequest $request)
    {
        $this->evolucion_service->store($request->validated());
        return redirect()->route('evolucion.index')->with('success', 'Evolucion creada correctamente');
    }

    public function show()
    {
        //
    }

    public function edit(int $id)
    {
        $evolucion = $this->evolucion_service->edit($id);
        $historiasClinicas = $this->historia_clinica_service->listartodo();
        $veterinarios = $this->veterinario_service->listartodo();
        return view('Evolucion.update', compact('evolucion','historiasClinicas', 'veterinarios'));
    }

    public function update(int $id, EvolucionStoreRequest $request)
    {
        $this->evolucion_service->update($id, $request->all());
        return redirect()->route('evolucion.index')->with('update', 'Evolucion actualizada correctamente');
    }

    public function destroy(int $id)
    {
        $this->evolucion_service->destroy($id);
        return redirect()->route('evolucion.index')->with('destroy', 'Evolucion eliminada correctamente');
    }
}
