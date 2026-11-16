<?php

namespace App\Repository;

use App\Models\MascotaAdopcion;

class MascotaAdopcionRepository
{
    // Listar todas las mascotas registradas.
    public function index()
    {
        return MascotaAdopcion::orderBy('created_at', 'desc')->paginate(10);
    }

    // Registrar una nueva mascota.
    public function store(array $datos)
    {
        return MascotaAdopcion::create($datos);
    }

    // Consultar una mascota por su ID.
    public function edit(int $id)
    {
        return MascotaAdopcion::findOrFail($id);
    }

    // Actualizar los datos de una mascota.
    public function update(int $id, array $datos)
    {
        $mascota = $this->edit($id);

        $mascota->update($datos);

        return $mascota;
    }

    // Eliminar una mascota.
    public function delete(int $id)
    {
        $mascota = $this->edit($id);

        return $mascota->delete();
    }

    // Consultar únicamente las mascotas disponibles para adopción.
    public function listarEnAdopcion()
    {
        return MascotaAdopcion::where('estado', 'En adopción')
            ->orderBy('created_at', 'desc')
            ->get();
    }
}
