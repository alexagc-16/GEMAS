<?php

namespace App\Http\Controllers\Seguridad;

use App\Http\Controllers\Controller;
use App\Services\Seguridad\RestablecerPasswordService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;

class RestablecerPasswordController extends Controller
{
    private RestablecerPasswordService $restablecerPasswordService;

    public function __construct(RestablecerPasswordService $restablecerPasswordService)
    {
        $this->restablecerPasswordService = $restablecerPasswordService;
    }

    public function create(string $token)
    {
        return view('seguridad.restablecerPassword', compact('token'));
    }

    public function store(Request $request)
    {
        $datos = $request->validate([
            'token' => 'required',
            'email' => 'required|email',
            'password' => 'required|string|min:8|confirmed',
        ], [
            'email.required' => 'El correo electrónico es obligatorio.',
            'email.email' => 'Ingresa un correo electrónico válido.',
            'password.required' => 'La contraseña es obligatoria.',
            'password.min' => 'La contraseña debe tener mínimo 8 caracteres.',
            'password.confirmed' => 'Las contraseñas no coinciden.',
        ]);

        $estado = $this->restablecerPasswordService->restablecerPassword($datos);

        if ($estado === Password::PASSWORD_RESET) {
            return redirect()->route('login')
                ->with('success', 'Tu contraseña se ha establecido correctamente.');
        }

        return back()
            ->withInput($request->only('email'))
            ->withErrors([
                'email' => 'El enlace no es válido o ha expirado.',
            ]);
    }
}

