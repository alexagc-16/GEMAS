<?php

namespace App\Http\Controllers;

use App\Http\Requests\VeterinarioStoreRequest;
use App\Models\Veterinario;
use App\Services\VeterinarioService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;

class VeterinarioController extends Controller
{
    private VeterinarioService $veterinario_service;

    public function __construct(VeterinarioService $veterinarioservice) {
        $this->veterinario_service = $veterinarioservice;
    }
    
    public function index()
    {
        $veterinarios = $this->veterinario_service->listarPaginado(10);
        return view('Veterinario.index', compact('veterinarios'));
    }

    public function create()
    {
        return view('Veterinario.create');
    }

    public function store(VeterinarioStoreRequest $request)
    {
        $estado = $this->veterinario_service->store(
            $request->validated()
        );

        if ($estado === Password::RESET_LINK_SENT) {
            return redirect()->route('veterinario.index')
                ->with('veterinarioRegistrado', true);
        }

        return redirect()->route('veterinario.index')
            ->with('warning', 'El veterinario fue creado, pero no se pudo enviar el correo. Puedes intentar nuevamente.');
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
        $this->veterinario_service->update($id, $request->validated());
        return redirect()->route('veterinario.index')->with('update', 'Veterinario actualizado correctamente');
    }

    public function destroy(int $id)
    {
        $this->veterinario_service->destroy($id);
        return redirect()->route('veterinario.index')->with('destroy', 'Veterinario eliminado correctamente');
    }
}
