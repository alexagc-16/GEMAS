<?php

namespace App\Http\Controllers;

use App\Http\Requests\VeterinarioStoreRequest;
use App\Models\Veterinario;
use App\Services\VeterinarioService;
use Illuminate\Http\Request;

class VeterinarioController extends Controller
{
    private VeterinarioService $veterinario_service;

    public function __construct(VeterinarioService $veterinarioservice) {
        $this->veterinario_service = $veterinarioservice;
    }
    
    public function index()
    {
        $veterinarios = $this->veterinario_service->listartodo();
        return view('Veterinario.index', compact('veterinarios'));
    }

    public function create()
    {
        return view('Veterinario.create');
    }

    public function store(VeterinarioStoreRequest $request)
    {
        $this->veterinario_service->store($request->validated());
        return redirect()->route('veterinario.index')->with('success', 'Veterinario creado correctamente');

    }

    public function show()
    {
        //
    }

    public function edit(int $id)
    {
        $veterinario = $this->veterinario_service->edit($id);
        return view('Veterinario.update', compact('veterinario'));
    }

    public function update(int $id, VeterinarioStoreRequest $request)
    {
        $this->veterinario_service->update($id, $request->all());
        return redirect()->route('veterinario.index')->with('update', 'Veterinario actualizado correctamente');
    }

    public function destroy(int $id)
    {
        $this->veterinario_service->destroy($id);
        return redirect()->route('veterinario.index')->with('destroy', 'Veterinario eliminado correctamente');
    }
}
