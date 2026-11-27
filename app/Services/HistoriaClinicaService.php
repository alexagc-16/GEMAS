<?php

namespace App\Services;

use App\Models\HistoriaClinica;
use App\Repository\HistoriaClinicaRepository;
use Illuminate\Validation\ValidationException;

class HistoriaClinicaService{

    private HistoriaClinicaRepository $historia_clinica_repository;

    public function __construct(HistoriaClinicaRepository $historiaclinicarepository)
    {
        $this->historia_clinica_repository = $historiaclinicarepository;
    }

    public function listarPaginado(int $porPagina = 10, array $filtros = [])
    {
        return $this->historia_clinica_repository
            ->listarPaginado($porPagina, $filtros);
    }

    public function listarPaginadoPorUsuario(
        int $idUsuario,
        int $porPagina = 10,
        array $filtros = []
    ) {
        return $this->historia_clinica_repository
            ->listarPaginadoPorUsuario($idUsuario, $porPagina, $filtros);
    }

    public function listartodo(){
        return $this->historia_clinica_repository->listartodo();
    }

    public function listarPendientes()
    {
        return $this->historia_clinica_repository->listarPendientes();
    }

    public function buscarParaConsulta(int $id)
    {
        return $this->historia_clinica_repository->buscarParaConsulta($id);
    }

    public function store(array $datos)
    {
        return $this->historia_clinica_repository->store($datos);
    }

    public function edit(int $id)
    {
        return $this->historia_clinica_repository->edit($id);
    }

    public function update(int $id, array $datos)
    {
        // Buscar la historia clínica
        $historiaClinica = $this->historia_clinica_repository->edit($id);

        // Verificar si ya fue completada
        if ($historiaClinica->completadaEn !== null) {
            throw ValidationException::withMessages([
                'historiaClinica' => 'Esta historia clínica ya fue completada y sus datos iniciales no se pueden modificar.',
            ]);
        }

        // Proteger los datos que no deben cambiar
        unset($datos['idMascota']);
        unset($datos['fechaApertura']);
        unset($datos['completadaEn']);

        // Registrar automáticamente la fecha de finalización
        $datos['completadaEn'] = now();

        return $this->historia_clinica_repository->update($id, $datos);
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