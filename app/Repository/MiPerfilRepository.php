<?php

namespace App\Repository;

use App\Models\Usuario;
use App\Models\Veterinario;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Models\Role;

class MiPerfilRepository
{
    public function obtenerPerfil()
    {
        $usuario = Auth::user();

        // Si es veterinario, consultar también su registro profesional
        if (Role::whereHas('users', function ($consulta) use ($usuario) {$consulta->where('model_id', $usuario->id);})->where('name', 'veterinario')->where('activo', true)->exists()) {
            $veterinario = Veterinario::where(
                'documentoIdentidad',
                $usuario->documentoIdentidad
            )->first();

            return [
                'usuario' => $usuario,
                'veterinario' => $veterinario,
            ];
        }

        return [
            'usuario' => $usuario,
            'veterinario' => null,
        ];
    }

    public function actualizarUsuario(Usuario $usuario, array $datos): void
    {
        $usuario->update($datos);
    }

    public function actualizarVeterinario(Veterinario $veterinario, array $datos): void
    {
        $veterinario->update($datos);
    }
}