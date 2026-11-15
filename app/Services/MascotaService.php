<?php

namespace App\Services;

use App\Repository\MascotaRepository;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class MascotaService{

    private MascotaRepository $mascota_repository;
    private HistoriaClinicaService $historia_clinica_service;

    public function __construct(MascotaRepository $mascotarepository, HistoriaClinicaService $historiaclinicaservice)
    {
        $this->mascota_repository = $mascotarepository;
        $this->historia_clinica_service = $historiaclinicaservice;
    }

    public function listarPaginado(
    int $porPagina = 10,
    array $filtros = []
    ) {
        return $this->mascota_repository->listarPaginado($porPagina, $filtros);
    }

    public function listarPaginadoPorUsuario(
        int $idUsuario,
        int $porPagina = 10,
        array $filtros = []
    ) {
        return $this->mascota_repository->listarPaginadoPorUsuario(
            $idUsuario,
            $porPagina,
            $filtros
        );
    }

    public function listarEspecies()
    {
        return $this->mascota_repository->listarEspecies();
    }

    public function listarTodo(){
        return $this->mascota_repository->listartodo();
    }

    public function listarPorUsuario(int $idUsuario)
    {
        return $this->mascota_repository->listarPorUsuario($idUsuario);
    }

    public function buscarPorUsuario(int $id, int $idUsuario)
    {
        return $this->mascota_repository->buscarPorUsuario($id, $idUsuario);
    }

    public function store(array $datos, $imagen = null)
    {
        return DB::transaction(function () use ($datos, $imagen) {

            // Guardar la imagen, si se seleccionó una
            if ($imagen) {
                $datos['imagen'] = $imagen->store('mascotas', 'public');
            }

            // Crear la mascota
            $mascota = $this->mascota_repository->store($datos);

            // Crear automáticamente su historia clínica
            $this->historia_clinica_service->store([
                'fechaApertura' => now()->toDateString(),
                'antecedentes' => null,
                'alergias' => null,
                'enfermedadesPrevias' => null,
                'observaciones' => null,
                'idMascota' => $mascota->id,
            ]);

            return $mascota;
        });
    }

    public function edit(int $id)
    {
        return $this->mascota_repository->edit($id);
    }

    public function update(int $id, array $datos, $imagen = null)
    {
        $mascota = $this->mascota_repository->edit($id);

        if (($datos['eliminar_imagen'] ?? '0') == '1') {

            // Eliminar archivo físico
            if ($mascota->imagen) {
                Storage::disk('public')->delete($mascota->imagen);
            }

            // Limpiar la ruta guardada en la base de datos
            $datos['imagen'] = null;
        }

        // Si se selecciona una nueva imagen
        if ($imagen) {

            if ($mascota->imagen) {
                Storage::disk('public')->delete($mascota->imagen);
            }

            $datos['imagen'] = $imagen->store('mascotas', 'public');
        }

        unset($datos['eliminar_imagen']);

        $this->mascota_repository->update($id, $datos);  
    }

    public function destroy(int $id)
    {
        $mascota = $this->mascota_repository->edit($id);

        // Eliminar archivo físico
        if ($mascota->imagen) {
            Storage::disk('public')->delete(
                $mascota->imagen
            );
        }
        
        $this->mascota_repository->destroy($id);
    }

}