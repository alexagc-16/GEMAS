<?php

namespace App\Repository;
use App\Models\HistoriaClinica;

class HistoriaClinicaRepository{

    public function listarPaginado(int $porPagina = 10)
    {
        return HistoriaClinica::with([
            'Mascota',
            'Evolucion.Veterinario',
            'Evolucion.DiagnosticoTratamiento'
        ])
            ->latest()
            ->paginate($porPagina);
    }

    public function listarPaginadoPorUsuario(int $idUsuario, int $porPagina = 10)
    {
        return HistoriaClinica::with([
            'Mascota',
            'Evolucion.Veterinario',
            'Evolucion.DiagnosticoTratamiento'
        ])
            ->whereHas('Mascota', function ($consulta) use ($idUsuario) {
                $consulta->where('idUsuario', $idUsuario);
            })
            ->latest()
            ->paginate($porPagina);
    }

    public function listartodo(){
        return HistoriaClinica::with('Mascota', 'Evolucion.Veterinario','Evolucion.DiagnosticoTratamiento')->get();
    }

    public function listarPendientes()
    {
        return HistoriaClinica::with('Mascota')
            ->whereNull('completadaEn')
            ->get();
    }

    public function buscarParaConsulta(int $id)
    {
        return HistoriaClinica::with([
            'Mascota',
            'Evolucion.Veterinario',
            'Evolucion.DiagnosticoTratamiento',
        ])->where('idMascota', $id)->firstOrFail();
    }

    public function store(array $datos)
    {
        return HistoriaClinica::create($datos);
    }

    public function edit(int $id)
    {
        return HistoriaClinica::findOrfail($id);
    }

    public function update(int $id, array $datos)
    {
        $historiaClinica = HistoriaClinica::findOrfail($id);
        $historiaClinica->update($datos);   
    }

    public function destroy(int $id)
    {
        HistoriaClinica::destroy($id);
    }
}