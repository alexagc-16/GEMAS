<?php

namespace App\Http\Controllers\Seguridad;

use App\Http\Controllers\Controller;
use App\Services\Seguridad\AuthService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use App\Services\UsuarioService;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function __construct(private AuthService $authService,
    private UsuarioService $usuarioService
    ) {}

    public function showLoginForm(): View
    {
        return view('seguridad.login');
    }

    public function login(Request $request): RedirectResponse
    {
        $credenciales = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required', 'string'],
        ]);

        $autenticado = $this->authService->autenticar(
            $credenciales['email'],
            $credenciales['password'],
            $request->boolean('remember')
        );

        if (! $autenticado) {
            return back()
                ->withErrors(['email' => 'Las credenciales no coinciden con nuestros registros.'])
                ->onlyInput('email');
        }

        $request->session()->regenerate();

        return redirect()->route('dashboard.index');
    }

    public function logout(Request $request): RedirectResponse
    {
        $this->authService->cerrarSesion();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }
    
    public function showRegistrationForm(): View
    {
        return view('seguridad.registro');
    }

    public function register(Request $request): RedirectResponse
    {
        $datos = $request->validate([
            'nombre' => ['required', 'string', 'max:255'],
            'apellido' => ['required', 'string', 'max:255'],
            'documentoIdentidad' => [
                'required',
                'string',
                'max:30',
                'unique:usuario,documentoIdentidad',
            ],
            'telefono' => ['required', 'string', 'max:20'],
            'direccion' => ['nullable', 'string', 'max:255'],
            'email' => [
                'required',
                'email',
                'max:255',
                'unique:usuario,email',
            ],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        $usuario = $this->usuarioService->store($datos);

        Auth::login($usuario);

        $request->session()->regenerate();

        return redirect()->intended(
            config('seguridad.redirect_despues_login')
        );
    }

}
