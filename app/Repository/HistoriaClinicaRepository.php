<?php

namespace App\Repository;
use App\Models\HistoriaClinica;

class HistoriaClinicaRepository{

    public function listarPaginado(int $porPagina = 10, array $filtros = [])
    {
        $consulta = HistoriaClinica::with([
            'Mascota',
            'Evolucion.Veterinario',
            'Evolucion.DiagnosticoTratamiento'
        ]);

        $this->aplicarFiltros($consulta, $filtros);

        return $consulta
            ->latest()
            ->paginate($porPagina);
    }

    public function listarPaginadoPorUsuario(int $idUsuario, int $porPagina = 10,array $filtros = []) 
    {
        $consulta = HistoriaClinica::with([
            'Mascota',
            'Evolucion.Veterinario',
            'Evolucion.DiagnosticoTratamiento'
        ])
            ->whereHas('Mascota', function ($consulta) use ($idUsuario) {
                $consulta->where('idUsuario', $idUsuario);
            });

        $this->aplicarFiltros($consulta, $filtros);

        return $consulta
            ->latest()
            ->paginate($porPagina);
    }

    /**
     * Aplicar los filtros de búsqueda de historias clínicas.
     */
    private function aplicarFiltros($consulta, array $filtros): void
    {
        // Buscar por nombre de mascota.
        if (!empty($filtros['buscar'])) {
            $buscar = trim($filtros['buscar']);

            $consulta->whereHas('Mascota', function ($subconsulta) use ($buscar) {
                $subconsulta->where('nombre', 'LIKE', "%{$buscar}%");
            });
        }

        // Filtrar por fecha de apertura.
        if (!empty($filtros['fecha'])) {
            $consulta->whereDate('fechaApertura', $filtros['fecha']);
        }

        // Filtrar por estado de la historia clínica.
        if (($filtros['estado'] ?? '') === 'completa') {
            $consulta->whereNotNull('completadaEn');
        } elseif (($filtros['estado'] ?? '') === 'pendiente') {
            $consulta->whereNull('completadaEn');
        }
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

    public function buscarParaPdf(int $id)
    {
        return HistoriaClinica::with([
            'Mascota',
            'Evolucion.Veterinario',
            'Evolucion.DiagnosticoTratamiento'
        ])->findOrFail($id);
    }

}