<?php

namespace App\Http\Controllers;

use App\Http\Requests\HistoriaClinicaStoreRequest;
use App\Models\HistoriaClinica;
use App\Services\HistoriaClinicaService;
use App\Services\MascotaService;
use Illuminate\Http\Request;

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
        $historiasClinicas = $this->historia_clinica_service->listartodo();
        return view('HistoriaClinica.index', compact('historiasClinicas'));
        
    }
    
    public function create()
    {
        $mascotas = $this->mascota_service->listartodo();
        return view('HistoriaClinica.create', compact('mascotas'));
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
        $mascotas = $this->mascota_service->listartodo();
        return view('HistoriaClinica.update', compact('historiaClinica', 'mascotas'));
    }

    public function update(int $id, HistoriaClinicaStoreRequest $request)
    {
        $this->historia_clinica_service->update($id, $request->all());
        return redirect()->route('historiaclinica.index')->with('update', 'Historia clinica actualizada correctamente');
    }

    public function destroy(int $id)
    {
        $this->historia_clinica_service->destroy($id);
        return redirect()->route('historiaclinica.index')->with('destroy', 'Historia clinica eliminada correctamente');
    }
}
