<?php

namespace App\Http\Controllers\Seguridad;

use App\Http\Controllers\Controller;
use App\Services\Seguridad\RecuperarPasswordService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class RecuperarPasswordController extends Controller
{
    public function __construct(
        private RecuperarPasswordService $recuperarPasswordService
    ) {
    }

    public function create(): View
    {
        return view('seguridad.recuperarPassword');
    }

    /**
     * Enviar código de recuperación al correo.
     */
    public function enviarCodigo(Request $request): RedirectResponse
    {
        logger()->info('Solicitud recibida para recuperar contraseña', [
            'url' => $request->fullUrl(),
            'ip' => $request->ip(),
            'email' => $request->input('email'),
        ]);

        $datos = $request->validate([
            'email' => ['required', 'email'],
        ]);

        $email = strtolower(trim($datos['email']));

        $enviado = $this->recuperarPasswordService
            ->enviarCodigo($email);

        if (!$enviado) {
            return back()
                ->withErrors([
                    'email' => 'Debes esperar 60 segundos antes de solicitar otro código.',
                ])
                ->withInput();
        }

        session([
            'emailRecuperacion' => $email,
        ]);

        return redirect()
            ->route('password.codigo.form')
            ->with('status', 'Si el correo está registrado, recibirás las instrucciones de recuperación.');
    }

    /**
     * Mostrar formulario para verificar el código.
     */
    public function mostrarVerificacion(): View|RedirectResponse
    {
        if (!session()->has('emailRecuperacion')) {
            return redirect()->route('password.request');
        }

        return view('seguridad.verificarCodigo');
    }

    /**
     * Verificar el código recibido.
     */
    public function verificarCodigo(Request $request): RedirectResponse
    {
        $datos = $request->validate([
            'codigo' => ['required', 'digits:6'],
        ]);

        $email = session('emailRecuperacion');

        if (!$email) {
            return redirect()->route('password.request');
        }

        $resultado = $this->recuperarPasswordService
            ->verificarCodigo($email, $datos['codigo']);

        if ($resultado['estado'] === 'expirado') {
            return back()->withErrors([
                'codigo' => 'El código ha expirado o no es válido. Solicita uno nuevo.',
            ]);
        }

        if ($resultado['estado'] === 'bloqueado') {
            session()->forget([
                'emailRecuperacion',
                'tokenRecuperacion',
            ]);

            return redirect()
                ->route('password.request')
                ->withErrors([
                    'email' => 'Has superado los cinco intentos. Solicita un nuevo código.',
                ]);
        }

        if ($resultado['estado'] === 'incorrecto') {
            return back()->withErrors([
                'codigo' => 'El código ingresado no es correcto. Intentos restantes: '
                    . $resultado['intentosRestantes'],
            ]);
        }

        session([
            'tokenRecuperacion' => $resultado['token'],
        ]);

        return redirect()->route('password.nueva.form');
    }

    /**
     * Mostrar formulario para establecer nueva contraseña.
     */
    public function mostrarNuevaPassword(): View|RedirectResponse
    {
        $email = session('emailRecuperacion');
        $token = session('tokenRecuperacion');

        if (!$email || !$token) {
            return redirect()->route('password.request');
        }

        $tokenValido = $this->recuperarPasswordService
            ->verificarToken($email, $token);

        if (!$tokenValido) {
            session()->forget([
                'emailRecuperacion',
                'tokenRecuperacion',
            ]);

            return redirect()->route('password.request')
                ->withErrors([
                    'email' => 'La verificación ha expirado. Solicita un nuevo código.',
                ]);
        }

        return view('seguridad.nuevaPassword');
    }

    /**
     * Actualizar la contraseña.
     */
    public function actualizarPassword(Request $request): RedirectResponse
    {
        $datos = $request->validate([
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        $email = session('emailRecuperacion');
        $token = session('tokenRecuperacion');

        if (!$email || !$token) {
            return redirect()->route('password.request');
        }

        $actualizado = $this->recuperarPasswordService
            ->actualizarPassword(
                $email,
                $token,
                $datos['password']
            );

        if (!$actualizado) {
            session()->forget([
                'emailRecuperacion',
                'tokenRecuperacion',
            ]);

            return redirect()->route('password.request')
                ->withErrors([
                    'email' => 'La verificación ha expirado. Solicita un nuevo código.',
                ]);
        }

        session()->forget([
            'emailRecuperacion',
            'tokenRecuperacion',
        ]);

        return redirect()->route('login')
            ->with('success', 'Tu contraseña se actualizó correctamente. Ya puedes iniciar sesión.');
    }
}