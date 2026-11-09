<?php

namespace App\Http\Controllers;

use App\Http\Requests\HistoriaClinicaStoreRequest;
use App\Models\HistoriaClinica;
use App\Services\HistoriaClinicaService;
use App\Services\MascotaService;
use Illuminate\Http\Request;
use App\Models\Usuario;
use Illuminate\Support\Facades\Auth;

class HistoriaClinicaController extends Controller
{

    private HistoriaClinicaService $historia_clinica_service;
    private MascotaService $mascota_service;

    public function __construct(HistoriaClinicaService $historiaclinicaservice, MascotaService $mascotaservice) {
        $this->historia_clinica_service = $historiaclinicaservice;
        $this->mascota_service = $mascotaservice;
    }
    
    public function index()
    {
        /** @var Usuario $usuario */
        $usuario = Auth::user();

        if ($usuario->tieneRolActivo('usuario')) {
            $historiasClinicas = $this->historia_clinica_service
                ->listarPaginadoPorUsuario($usuario->id, 10);
        } else {
            $historiasClinicas = $this->historia_clinica_service
                ->listarPaginado(10);
        }

        return view('HistoriaClinica.index', compact('historiasClinicas'));
    }
    
    public function create()
    {
        $historiasClinicas = $this->historia_clinica_service->listarPendientes();

        return view('HistoriaClinica.create', compact('historiasClinicas'));
    }

    public function store(HistoriaClinicaStoreRequest $request)
    {
        $this->historia_clinica_service->store($request->validated());
        return redirect()->route('historiaclinica.index')->with('sucess', 'Historia clinica creada correctamente');
    }

    public function show()
    {
        //
    }

    public function edit(int $id)
    {
        $historiaClinica = $this->historia_clinica_service->edit($id);

        // Evitar modificar una historia clínica ya completada
        if ($historiaClinica->completadaEn !== null) {
            return redirect()
                ->route('historiaclinica.index')
                ->with('error', 'Esta historia clínica ya fue completada y no se puede modificar.');
        }

        return view('HistoriaClinica.update', compact('historiaClinica'));
    }

    public function update(int $id, HistoriaClinicaStoreRequest $request)
    {
        $this->historia_clinica_service->update($id, $request->validated());
        return redirect()->route('historiaclinica.index')->with('update', 'Historia clinica actualizada correctamente');
    }

    public function destroy(int $id)
    {
        $this->historia_clinica_service->destroy($id);
        return redirect()->route('historiaclinica.index')->with('destroy', 'Historia clinica eliminada correctamente');
    }
}

