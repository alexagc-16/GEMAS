<?php

namespace App\Http\Controllers;

use App\Models\Cita;
use App\Models\Veterinario;
use App\Services\DashService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    private DashService $dash_service;

    public function __construct(DashService $dashservice) {
        $this->dash_service = $dashservice;
    }

    
    public function index(Request $request)
    {
        // Identificar el rol del usuario autenticado
        /** @var \App\Models\Usuario $usuarioActual */
        $usuarioActual = auth()->guard()->user();

        abort_unless($usuarioActual instanceof \App\Models\Usuario, 403);

        $rolActual = $usuarioActual->roles()->first()?->name;

        // Mostrar el dashboard correspondiente según el rol
        switch ($rolActual) {
            case 'administrador':

                // Total de mascotas registradas
                $totalMascotas = $this->dash_service->TotalMascotas();

                // Total de usuarios registrados
                $totalUsuarios = $this->dash_service->TotalUsuarios();

                // Citas programadas para hoy
                $citasHoy = $this->dash_service->TotalCitasHoy();

                // Total de citas del mes
                $totalCitasMes = $this->dash_service->TotalCitasMes();

                // Citas de hoy
                $citasDelDia = $this->dash_service->CitasDelDia();

                // Próximas citas
                $proximasCitas = $this->dash_service->ProximasCitas();

                // Citas por mes
                $datosCitasPorMes = $this->dash_service->CitasPorMes();

                // Servicios más solicitados
                $serviciosMasSolicitados = $this->dash_service->ServiciosMasSolicitados();

                return view('dashboard.index', compact(
                    'totalMascotas',
                    'totalUsuarios',
                    'citasHoy',
                    'totalCitasMes',
                    'citasDelDia',
                    'proximasCitas',
                    'datosCitasPorMes',
                    'serviciosMasSolicitados'
                ));

            case 'veterinario':

                // Identificar el veterinario relacionado con el usuario
                $veterinario = Veterinario::where(
                    'documentoIdentidad',
                    $usuarioActual->documentoIdentidad
                )->firstOrFail();

                // Especialidad del veterinario
                $especialidad = $veterinario->especialidad;

                // Historias clínicas pendientes por completar
                $historiasPendientes = $this->dash_service
                    ->TotalHistoriasPendientesVeterinario();

                // Listado de máximo 5 historias pendientes
                $listadoHistoriasPendientes = $this->dash_service
                    ->HistoriasPendientesVeterinario();

                // Actividad del veterinario
                $actividadVeterinario = $this->dash_service
                    ->CitasPorEstadoVeterinario($veterinario->id);

                // Citas de hoy
                $citasHoy = $this->dash_service
                    ->CitasHoyVeterinario($veterinario->id);

                // Citas del mes
                $totalCitasMes = $this->dash_service
                    ->CitasMesVeterinario($veterinario->id);

                return view('dashboard.veterinario', compact(
                    'veterinario',
                    'especialidad',
                    'historiasPendientes',
                    'listadoHistoriasPendientes',
                    'actividadVeterinario',
                    'citasHoy',
                    'totalCitasMes'
                ));
                
            case 'usuario':

            $idUsuario = $usuarioActual->id;

            $mascotas = $this->dash_service->MascotasUsuario($idUsuario);

            $proximasCitas = $this->dash_service->ProximasCitasUsuario($idUsuario);

            $serviciosRecibidos = $this->dash_service->ServiciosRecibidosUsuario($idUsuario);

            $totalMascotas = $this->dash_service->TotalMascotasUsuario($idUsuario);

            $totalProximasCitas = $this->dash_service->TotalProximasCitasUsuario($idUsuario);

            $totalHistorias = $this->dash_service->TotalHistoriasUsuario($idUsuario);

            $totalServiciosRecibidos = $this->dash_service->TotalServiciosRecibidosUsuario($idUsuario);

            return view('dashboard.usuario', compact(
                'usuarioActual',
                'mascotas',
                'proximasCitas',
                'serviciosRecibidos',
                'totalMascotas',
                'totalProximasCitas',
                'totalHistorias',
                'totalServiciosRecibidos'
            ));
    
            default:
                abort(403, 'No tienes un rol válido para acceder al dashboard.');
        }
    }

}