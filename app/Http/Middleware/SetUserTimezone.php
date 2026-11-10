<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SetUserTimezone
{
    public function handle(Request $request, Closure $next): Response
    {
        // Obtener la zona horaria configurada para la aplicación.
        $timezone = config('app.timezone', 'America/Bogota');

        // Aplicar la zona horaria a las operaciones de PHP.
        date_default_timezone_set($timezone);

        return $next($request);
    }
}

