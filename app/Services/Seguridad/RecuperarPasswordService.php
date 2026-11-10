<?php

namespace App\Services\Seguridad;

use App\Mail\CodigoRecuperacionMail;
use App\Repository\Seguridad\RecuperarPasswordRepository;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Throwable;

class RecuperarPasswordService
{
    public function __construct(
        private RecuperarPasswordRepository $recuperarPasswordRepository
    ) {
    }

    /**
     * Enviar código de recuperación al correo.
     */
    public function enviarCodigo(string $email): bool
    {
        $email = strtolower(trim($email));
        $clave = hash('sha256', $email);

        $cooldownKey = "recuperacion:espera:{$clave}";
        $codigoKey = "recuperacion:codigo:{$clave}";
        $intentosKey = "recuperacion:intentos:{$clave}";

        $resultadoCache = Cache::add(
            $cooldownKey,
            true,
            now()->addSeconds(60)
        );

        if (!$resultadoCache) {
            return false;
        }

        $usuario = $this->recuperarPasswordRepository
            ->buscarPorEmail($email);

        // No revelar si el correo está registrado.
        if (!$usuario) {
            return true;
        }

        $codigo = (string) random_int(100000, 999999);

        Cache::put(
            $codigoKey,
            Hash::make($codigo),
            now()->addMinutes(10)
        );

        Cache::put(
            $intentosKey,
            0,
            now()->addMinutes(10)
        );

        try {
            Mail::to($email)->send(
                new CodigoRecuperacionMail($codigo)
            );
        } catch (Throwable $error) {
            Cache::forget($codigoKey);
            Cache::forget($intentosKey);
            Cache::forget($cooldownKey);

            report($error);
        }

        return true;
    }

    /**
     * Verificar el código enviado al correo.
     */
    public function verificarCodigo(string $email, string $codigo): array
    {
        $clave = hash('sha256', strtolower(trim($email)));

        $codigoKey = "recuperacion:codigo:{$clave}";
        $intentosKey = "recuperacion:intentos:{$clave}";

        $codigoGuardado = Cache::get($codigoKey);

        if (!$codigoGuardado) {
            return ['estado' => 'expirado'];
        }

        if (!Hash::check($codigo, $codigoGuardado)) {
            $intentos = Cache::increment($intentosKey);

            if ($intentos >= 5) {
                Cache::forget($codigoKey);
                Cache::forget($intentosKey);

                return ['estado' => 'bloqueado'];
            }

            return [
                'estado' => 'incorrecto',
                'intentosRestantes' => 5 - $intentos,
            ];
        }

        Cache::forget($codigoKey);
        Cache::forget($intentosKey);

        $token = Str::random(64);

        Cache::put(
            "recuperacion:verificada:{$clave}",
            Hash::make($token),
            now()->addMinutes(10)
        );

        return [
            'estado' => 'correcto',
            'token' => $token,
        ];
    }

    /**
     * Comprobar que el código fue verificado previamente.
     */
    public function verificarToken(string $email, string $token): bool
    {
        $clave = hash('sha256', strtolower(trim($email)));

        $tokenGuardado = Cache::get(
            "recuperacion:verificada:{$clave}"
        );

        return $tokenGuardado !== null
            && Hash::check($token, $tokenGuardado);
    }

    /**
     * Actualizar la contraseña después de verificar el token.
     */
    public function actualizarPassword(
        string $email,
        string $token,
        string $password
    ): bool {
        if (!$this->verificarToken($email, $token)) {
            return false;
        }

        $usuario = $this->recuperarPasswordRepository
            ->buscarPorEmail(strtolower(trim($email)));

        if (!$usuario) {
            return false;
        }

        $this->recuperarPasswordRepository
            ->actualizarPassword($usuario, $password);

        $clave = hash('sha256', strtolower(trim($email)));

        Cache::forget("recuperacion:verificada:{$clave}");

        return true;
    }
}
