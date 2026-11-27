<?php

namespace App\Services;

use App\Repository\Seguridad\UsuarioRepository;
use App\Repository\VeterinarioRepository;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Password;
use Throwable;

class VeterinarioService{

    private VeterinarioRepository $veterinario_repository;
    private UsuarioRepository $usuario_repository;

    public function __construct(VeterinarioRepository $veterinariorepository, UsuarioRepository $usuariorepository)
    {
        $this->veterinario_repository = $veterinariorepository;
        $this->usuario_repository = $usuariorepository;
    }

    public function listarPaginado(int $porPagina = 10, array $filtros = [])
    {
        return $this->veterinario_repository->listarPaginado(
            $porPagina,
            $filtros
        );
    }

    public function listarEspecialidades()
    {
        return $this->veterinario_repository->listarEspecialidades();
    }

    public function listartodo(){
        return $this->veterinario_repository->listartodo();
    }
    
    public function store(array $datos)
    {
        // Crear el perfil y la cuenta dentro de una transacción
        DB::transaction(function () use ($datos) {

            // 1. Crear perfil del veterinario
            $veterinario = $this->veterinario_repository->store($datos);

            // 2. Crear cuenta de usuario
            $usuario = $this->usuario_repository->crear([
                'nombre' => $datos['nombre'],
                'apellido' => $datos['apellido'],
                'documentoIdentidad' => $datos['documentoIdentidad'],
                'telefono' => $datos['telefono'],
                'direccion' => null,
                'email' => $datos['email'],
                'password' => Str::random(40),
            ]);

            // 3. Asignar rol veterinario
            $this->usuario_repository->sincronizarRoles(
                $usuario,
                ['veterinario']
            );
        });

        // 4. Enviar enlace después de confirmar la transacción
        try {
            return Password::broker('users')->sendResetLink([
                'email' => $datos['email'],
            ]);

        } catch (Throwable $error) {
            report($error);

            return null;
        }
    }

    public function edit(int $id)
    {
        return $this->veterinario_repository->edit($id);
    }

    public function update(int $id, array $datos)
    {
        return DB::transaction(function () use ($id, $datos) {

            // 1. Obtener el veterinario actual
            $veterinario = $this->veterinario_repository->edit($id);

            // 2. Buscar su cuenta mediante el documento actual
            $usuario = $this->usuario_repository->buscarPorDocumento(
                $veterinario->documentoIdentidad
            );

            if (!$usuario) {
                throw new \RuntimeException(
                    'No se encontró la cuenta asociada al veterinario.'
                );
            }

            // 3. Actualizar el perfil del veterinario
            $this->veterinario_repository->update($id, $datos);

            // 4. Actualizar los datos de su cuenta
            $this->usuario_repository->actualizar($usuario, [
                'nombre' => $datos['nombre'],
                'apellido' => $datos['apellido'],
                'documentoIdentidad' => $datos['documentoIdentidad'],
                'telefono' => $datos['telefono'],
                'email' => $datos['email'],
            ]);
        });
    }    
}