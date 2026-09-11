<?php

namespace App\Http\Controllers;

use App\Http\Requests\HorarioStoreRequest;
use App\Models\Horario;
use App\Services\HorarioService;
use App\Services\VeterinarioService;
use Illuminate\Http\Request;

class HorarioController extends Controller
{
    private HorarioService $horario_service;
    private VeterinarioService $veterinario_service;

    public function __construct(HorarioService $horarioservice, VeterinarioService $veterinarioservice) {
        $this->horario_service = $horarioservice;
        $this->veterinario_service = $veterinarioservice;
    }
    
    public function index()
    {
        $horarios = $this->horario_service->listartodo();
        return view('Horario.index', compact('horarios'));
    }

    public function create()
    {
        $veterinarios = $this->veterinario_service->listartodo();
        return view('Horario.create', compact('veterinarios'));
    }

    public function store(HorarioStoreRequest $request)
    {
        $this->horario_service->store($request->validated());
        return redirect()->route('horario.index')->with('success','Horario creado correctamente');
    }

    public function show()
    {
        //
    }

    public function edit(int $id)
    {
        $horario = $this->horario_service->edit($id);
        $veterinarios = $this->veterinario_service->listartodo();
        return view('Horario.update', compact('horario', 'veterinarios'));
    }

    public function update(int $id, HorarioStoreRequest $request)
    {
        $this->horario_service->update($id, $request->all());
        return redirect()->route('horario.index')->with('update', 'Horario actualizado correctamente');
    }

    public function destroy(int $id)
    {
        $this->horario_service->destroy($id);
        return redirect()->route('horario.index')->with('destroy', 'Horario eliminado correctamente');
    }
}
