<?php

namespace App\Http\Controllers;

use App\Http\Requests\DiagnosticoTratamientoStoreRequest;
use App\Models\DiagnosticoTratamiento;
use App\Services\DiagnosticoTratamientoService;
use App\Services\EvolucionService;
use Illuminate\Http\Request;

class DiagnosticoTratamientoController extends Controller
{

    private DiagnosticoTratamientoService $diagnostico_tratamiento_service;
    private EvolucionService $evolucion_service;

    public function __construct(DiagnosticoTratamientoService $diagnosticotratamientoservice, EvolucionService $evolucionservice) {
        $this->diagnostico_tratamiento_service = $diagnosticotratamientoservice;
        $this->evolucion_service= $evolucionservice;
    }
    
    public function index()
    {
        $diagnosticosTratamientos = $this->diagnostico_tratamiento_service->listartodo();
        return view('DiagnosticoTratamiento.index', compact('diagnosticosTratamientos'));
    }

    public function create()
    {
        $diagnosticosTratamientos = $this->diagnostico_tratamiento_service->listartodo();
        $evoluciones = $this->evolucion_service->listartodo();
        return view('DiagnosticoTratamiento.create', compact('diagnosticosTratamientos', 'evoluciones'));
    }

    public function store(DiagnosticoTratamientoStoreRequest $request)
    {
        $this->diagnostico_tratamiento_service->store($request->validated());
        return redirect()->route('diagnosticotratamiento.index')->with('success', 'Diagnostico Tratamiento creddado correctamente');
    }

    public function show()
    {
        //
    }

    public function edit(int $id)
    {
        $diagnosticoTratamiento = $this->diagnostico_tratamiento_service->edit($id);
        $evoluciones = $this->evolucion_service->listartodo();
        return view('DiagnosticoTratamiento.update', compact('diagnosticoTratamiento', 'evoluciones'));
    }

    public function update(int $id, DiagnosticoTratamientoStoreRequest $request)
    {
        $this->diagnostico_tratamiento_service->update($id, $request->all());
        return redirect()->route('diagnosticotratamiento.index')->with('update', 'Diagnostico Tratamiento actualizado correctamente');
    }

    public function destroy(int $id)
    {
        $this->diagnostico_tratamiento_service->destroy($id);
        return redirect()->route('diagnosticotratamiento.index')->with('destroy', 'Diagnostico Tratamiento eliminado correctamente');
    }
}
