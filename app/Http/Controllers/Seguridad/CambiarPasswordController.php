<?php

namespace App\Http\Controllers\Seguridad;

use App\Http\Controllers\Controller;
use App\Services\Seguridad\CambiarPasswordService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CambiarPasswordController extends Controller
{
    private CambiarPasswordService $cambiar_password_service;

    public function __construct(CambiarPasswordService $cambiarpasswordservice)
    {
        $this->cambiar_password_service = $cambiarpasswordservice;
    }

    public function edit()
    {
        return view('seguridad.cambiarPassword');
    }

    public function update(Request $request)
    {
        $datos = $request->validate([
            'passwordActual' => 'required|string',
            'password' => 'required|string|min:8|confirmed',
        ], [
            'passwordActual.required' => 'Debes ingresar tu contraseña actual.',
            'password.required' => 'La nueva contraseña es obligatoria.',
            'password.min' => 'La nueva contraseña debe tener mínimo 8 caracteres.',
            'password.confirmed' => 'Las contraseñas no coinciden.',
        ]);

        $resultado = $this->cambiar_password_service->cambiarPassword(
            Auth::user(),
            $datos
        );

        if (!$resultado) {
            return back()->withErrors([
                'passwordActual' => 'La contraseña actual es incorrecta.',
            ]);
        }

        return back()->with(
            'success',
            'Tu contraseña se actualizó correctamente.'
        );
    }
}