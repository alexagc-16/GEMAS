<?php

namespace App\Services;

use App\Repository\MascotaAdopcionRepository;
use Illuminate\Support\Facades\Storage;

class MascotaAdopcionService
{
    private MascotaAdopcionRepository $mascota_adopcion_repository;

    public function __construct(MascotaAdopcionRepository $mascotaadopcionrepository)
    {
        $this->mascota_adopcion_repository = $mascotaadopcionrepository;
    }

    // Listar todas las mascotas para el administrador.
    public function index()
    {
        return $this->mascota_adopcion_repository->index();
    }

    // Registrar una nueva mascota.
    public function store(array $datos)
    {
        $imagen = $datos['imagen'];

        $datos['imagen'] = $imagen->store('mascotasAdopcion', 'public');

        return $this->mascota_adopcion_repository->store($datos);
    }

    // Consultar una mascota por su ID.
    public function edit(int $id)
    {
        return $this->mascota_adopcion_repository->edit($id);
    }

    // Actualizar los datos de una mascota.
    public function update(int $id, array $datos)
    {
        $mascota = $this->mascota_adopcion_repository->edit($id);

        // Si se selecciona una nueva imagen, reemplazar la anterior.
        if (isset($datos['imagen'])) {
            $imagenAnterior = $mascota->imagen;

            $datos['imagen'] = $datos['imagen']->store('mascotasAdopcion', 'public');
        } else {
            $imagenAnterior = null;
        }

        $mascotaActualizada = $this->mascota_adopcion_repository->update($id, $datos);

        // Eliminar la imagen anterior después de actualizar el registro.
        if ($imagenAnterior) {
            Storage::disk('public')->delete($imagenAnterior);
        }

        return $mascotaActualizada;
    }

    // Eliminar una mascota y su fotografía.
    public function delete(int $id)
    {
        $mascota = $this->mascota_adopcion_repository->edit($id);

        $eliminado = $this->mascota_adopcion_repository->delete($id);

        if ($eliminado) {
            Storage::disk('public')->delete($mascota->imagen);
        }

        return $eliminado;
    }

    // Consultar las mascotas que están en adopción.
    public function listarEnAdopcion()
    {
        return $this->mascota_adopcion_repository->listarEnAdopcion();
    }
}
