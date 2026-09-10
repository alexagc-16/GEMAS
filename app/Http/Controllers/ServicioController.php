<?php

namespace App\Http\Controllers;

use App\Http\Requests\ServicioStoreRequest;
use App\Models\Servicio;
use App\Services\ServicioService;
use Illuminate\Http\Request;

class ServicioController extends Controller
{

    private ServicioService $servicio_service;

    public function __construct(ServicioService $servicioservice) {
        $this->servicio_service = $servicioservice;  
    }
    
    public function index()
    {
        $servicios = $this->servicio_service->listarTodo();
        return view('Servicio.index', compact('servicios'));
    }

    public function create()
    {
        return view('Servicio.create');
    }

    public function store(ServicioStoreRequest $request)
    {
        $this->servicio_service->store($request->validated());
        return redirect()->route('servicio.index')->with('success', 'Servicio creado correctamente');
    }

    public function show()
    {
        //
    }

    public function edit(int $id)
    {
        $servicio = $this->servicio_service->edit($id);
        return view('Servicio.update', compact('servicio'));
    }

    public function update(int $id, ServicioStoreRequest $request)
    {
        $this->servicio_service->update($id, $request->all());
        return redirect()->route('servicio.index')->with('update', 'Servicio actualizado correctamente');
    }

    public function destroy(int $id)
    {
        $this->servicio_service->destroy($id);
        return redirect()->route('servicio.index')->with('destroy', 'Servicio eliminado correctamente');
    }
}
