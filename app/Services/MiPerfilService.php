<?php

namespace App\Services;

use App\Models\Usuario;
use App\Models\Veterinario;
use App\Repository\MiPerfilRepository;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use RuntimeException;

class MiPerfilService
{
    private MiPerfilRepository $mi_perfil_repository;

    public function __construct(MiPerfilRepository $miPerfilRepository)
    {
        $this->mi_perfil_repository = $miPerfilRepository;
    }

    public function obtenerPerfil()
    {
        return $this->mi_perfil_repository->obtenerPerfil();
    }

    public function actualizarPerfil(array $datos): void
    {
        DB::transaction(function () use ($datos) {

            $usuario = Auth::user();

            // Datos que se actualizan en la cuenta
            $datosUsuario = [
                'nombre' => $datos['nombre'],
                'apellido' => $datos['apellido'],
                'telefono' => $datos['telefono'],
                'email' => $datos['email'],
            ];

            // Si es propietario, también puede actualizar su dirección
            if (array_key_exists('direccion', $datos)) {
                $datosUsuario['direccion'] = $datos['direccion'];
            }

            $this->mi_perfil_repository->actualizarUsuario(
                $usuario,
                $datosUsuario
            );

            // Sincronizar los datos si es veterinario
            $perfil = $this->mi_perfil_repository->obtenerPerfil();

            if ($perfil['veterinario']) {

                $this->mi_perfil_repository->actualizarVeterinario(
                    $perfil['veterinario'],
                    [
                        'nombre' => $datos['nombre'],
                        'apellido' => $datos['apellido'],
                        'telefono' => $datos['telefono'],
                        'email' => $datos['email'],
                    ]
                );
            }
        });
    }
}