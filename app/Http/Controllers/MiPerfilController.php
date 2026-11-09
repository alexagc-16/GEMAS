<?php

namespace App\Http\Controllers;

use App\Services\MiPerfilService;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Services\Seguridad\CuentaService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;

class MiPerfilController extends Controller
{
    private MiPerfilService $mi_perfil_service;
    private CuentaService $cuenta_service;

    public function __construct(MiPerfilService $miPerfilService, CuentaService $cuentaservice)
    {
        $this->mi_perfil_service = $miPerfilService;
        $this->cuenta_service = $cuentaservice;
    }

    public function index()
    {
        $perfil = $this->mi_perfil_service->obtenerPerfil();

        return view('Perfil.index', compact('perfil'));
    }

    public function edit()
    {
        $perfil = $this->mi_perfil_service->obtenerPerfil();

        $esAdministrador = \Spatie\Permission\Models\Role::whereHas('users', function ($consulta) use ($perfil) {
            $consulta->where('model_id', $perfil['usuario']->id);
        })
        ->where('name', 'administrador')
        ->where('activo', true)
        ->exists();

        return view('Perfil.edit', compact('perfil', 'esAdministrador'));
    }

    public function update(Request $request)
    {
        $perfil = $this->mi_perfil_service->obtenerPerfil();
        $usuario = $perfil['usuario'];

        $reglas = [
            'nombre' => 'required|string|max:255',
            'apellido' => 'required|string|max:255',
            'telefono' => 'required|string|max:20',
            'email' => [
                'required',
                'email',
                'max:255',
                Rule::unique('usuario', 'email')->ignore($usuario->id),
            ],
        ];

        // Validar también el correo en la tabla veterinario
        if ($perfil['veterinario']) {
            $reglas['email'][] = Rule::unique('veterinario', 'email')
                ->ignore($perfil['veterinario']->id);
        }

        // La dirección solo se valida para cuentas de usuario propietario
        $esAdministrador = \Spatie\Permission\Models\Role::whereHas('users', function ($consulta) use ($usuario) {$consulta->where('model_id', $usuario->id);})->where('name', 'administrador')->where('activo', true)->exists();

        if (!$perfil['veterinario'] && !$esAdministrador) {
            $reglas['direccion'] = 'nullable|string|max:255';
        }

        $datos = $request->validate($reglas, [
            'nombre.required' => 'El nombre es obligatorio.',
            'apellido.required' => 'El apellido es obligatorio.',
            'telefono.required' => 'El teléfono es obligatorio.',
            'email.required' => 'El correo electrónico es obligatorio.',
            'email.email' => 'Ingresa un correo electrónico válido.',
            'email.unique' => 'Este correo electrónico ya está registrado.',
        ]);

        $this->mi_perfil_service->actualizarPerfil($datos);

        return redirect()->route('perfil.index')
            ->with('success', 'Tu perfil se actualizó correctamente.');
    }

    public function desactivar(Request $request): RedirectResponse
    {
        $usuario = $request->user();

        try {
            // El propietario desactiva su propia cuenta.
            $this->cuenta_service->desactivar($usuario, $usuario);
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }

        // Cerrar la sesión del usuario.
        Auth::guard(config('seguridad.guard'))->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login')
            ->with('success', 'Tu cuenta ha sido desactivada. Puedes recuperarla iniciando sesión nuevamente dentro de los próximos 7 días.');
    }
}