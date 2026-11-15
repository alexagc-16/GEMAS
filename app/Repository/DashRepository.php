<?php

namespace App\Repository;

use App\Models\Cita;
use App\Models\Mascota;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class DashRepository{
    
    public function TotalMascotas(){
        return DB::table('mascota')->count();
    }

    public function TotalUsuarios(){
        return DB::table('usuario')->count();
    }

    public function TotalCitasHoy(){
        return DB::table('cita')
            ->whereDate('fecha', Carbon::today())
            ->count();
    }    

    public function TotalCitasMes(){
        return DB::table('cita')
            ->whereMonth('fecha', now()->month)
            ->whereYear('fecha', now()->year)
            ->count();
    }  

    public function CitasDelDia(){
        return Cita::with(['Mascota', 'Veterinario', 'Servicio'])
            ->whereDate('fecha', Carbon::today())
            ->orderBy('hora', 'asc')
            ->get();
    }

    public function ProximasCitas(){
        return Cita::with(['Mascota', 'Veterinario', 'Servicio'])
            ->whereDate('fecha', '>', Carbon::today())
            ->whereIn('estado', ['Pendiente', 'Confirmada'])
            ->orderBy('fecha', 'asc')
            ->orderBy('hora', 'asc')
            ->take(5)
            ->get();
    }

    public function CitasPorMes()
    {
        $citasPorMes = Cita::selectRaw('MONTH(fecha) as mes, COUNT(*) as total')
            ->whereYear('fecha', Carbon::now()->year)
            ->groupBy('mes')
            ->orderBy('mes')
            ->get();

        $meses = [
            1 => 'Enero',
            2 => 'Febrero',
            3 => 'Marzo',
            4 => 'Abril',
            5 => 'Mayo',
            6 => 'Junio',
            7 => 'Julio',
            8 => 'Agosto',
            9 => 'Septiembre',
            10 => 'Octubre',
            11 => 'Noviembre',
            12 => 'Diciembre',
        ];

        $datosCitasPorMes = [];

        foreach ($meses as $numeroMes => $nombreMes) {
            $citaMes = $citasPorMes->firstWhere('mes', $numeroMes);

            $datosCitasPorMes[] = [
                'mes' => $nombreMes,
                'total' => $citaMes ? $citaMes->total : 0,
            ];
        }

        return $datosCitasPorMes;
    }

    
    public function ServiciosMasSolicitados()
    {
        $servicios = DB::table('cita')
            ->join('servicio', 'cita.idServicio', '=', 'servicio.id')
            ->select(
                'servicio.id',
                'servicio.nombre',
                DB::raw('COUNT(cita.id) as total')
            )
            ->groupBy('servicio.id', 'servicio.nombre')
            ->orderByDesc('total')
            ->take(5)
            ->get();

        // Total de citas que tienen un servicio registrado.
        $totalCitasConServicio = DB::table('cita')
            ->whereNotNull('idServicio')
            ->count();

        // Calcular el porcentaje de cada servicio.
        return $servicios->map(function ($servicio) use ($totalCitasConServicio) {
            $servicio->porcentaje = $totalCitasConServicio > 0
                ? round(($servicio->total / $totalCitasConServicio) * 100, 1)
                : 0;

            return $servicio;
        });
    }

    // Buscar veterinario por documento de identidad
    public function VeterinarioPorDocumento(string $documentoIdentidad)
    {
        return DB::table('veterinario')
            ->where('documentoIdentidad', $documentoIdentidad)
            ->first();
    }

    // Cantidad de citas de hoy del veterinario
    public function CitasHoyVeterinario(int $idVeterinario)
    {
        return DB::table('cita')
            ->where('idVeterinario', $idVeterinario)
            ->whereDate('fecha', Carbon::today())
            ->count();
    }

    // Cantidad de citas del mes del veterinario
    public function CitasMesVeterinario(int $idVeterinario)
    {
        return DB::table('cita')
            ->where('idVeterinario', $idVeterinario)
            ->whereMonth('fecha', Carbon::now()->month)
            ->whereYear('fecha', Carbon::now()->year)
            ->count();
    }

    // Historias clínicas pendientes por completar
    public function HistoriasPendientesVeterinario()
    {
        return DB::table('historiaClinica as hc')
            ->join('mascota as m', 'hc.idMascota', '=', 'm.id')
            ->whereNull('hc.completadaEn')
            ->select(
                'hc.id',
                'hc.idMascota',
                'hc.fechaApertura',
                'm.nombre as mascota'
            )
            ->orderBy('hc.fechaApertura', 'asc')
            ->limit(5)
            ->get();
    }

    // Total de historias clínicas pendientes por completar
    public function TotalHistoriasPendientesVeterinario()
    {
        return DB::table('historiaClinica')
            ->whereNull('completadaEn')
            ->count();
    }

    // Citas agrupadas por estado del veterinario
    public function CitasPorEstadoVeterinario(int $idVeterinario)
    {
        $resultados = DB::table('cita')
            ->selectRaw('LOWER(TRIM(estado)) as estado, COUNT(*) as total')
            ->where('idVeterinario', $idVeterinario)
            ->groupByRaw('LOWER(TRIM(estado))')
            ->pluck('total', 'estado');

        return [
            'Confirmada' => (int) $resultados->get('confirmada', 0),
            'Atendida' => (int) $resultados->get('atendida', 0),
            'Cancelada' => (int) $resultados->get('cancelada', 0),
            'No asistió' => (int) $resultados->get('no asistio', 0),
        ];
    }


    // Mascotas registradas por el usuario
    public function MascotasUsuario(int $idUsuario)
    {
        return Mascota::with('HistoriaClinica')
            ->where('idUsuario', $idUsuario)
            ->orderBy('nombre', 'asc')
            ->get();
    }

    // Próximas citas del usuario
    public function ProximasCitasUsuario(int $idUsuario)
    {
        return Cita::with(['Mascota', 'Veterinario', 'Servicio'])
            ->whereHas('Mascota', function ($query) use ($idUsuario) {
                $query->where('idUsuario', $idUsuario);
            })
            ->whereDate('fecha', '>=', Carbon::today())
            ->whereIn('estado', ['Pendiente', 'Confirmada'])
            ->orderBy('fecha', 'asc')
            ->orderBy('hora', 'asc')
            ->take(5)
            ->get();
    }

    // Servicios recibidos por las mascotas del usuario
    public function ServiciosRecibidosUsuario(int $idUsuario)
    {
        return Cita::with(['Mascota', 'Veterinario', 'Servicio'])
            ->whereHas('Mascota', function ($query) use ($idUsuario) {
                $query->where('idUsuario', $idUsuario);
            })
            ->where('estado', 'Atendida')
            ->whereNotNull('idServicio')
            ->orderBy('fecha', 'desc')
            ->get();
    }

    // Cantidad de mascotas del usuario
    public function TotalMascotasUsuario(int $idUsuario)
    {
        return DB::table('mascota')
            ->where('idUsuario', $idUsuario)
            ->count();
    }

    // Cantidad de próximas citas del usuario
    public function TotalProximasCitasUsuario(int $idUsuario)
    {
        return Cita::whereHas('Mascota', function ($query) use ($idUsuario) {
                $query->where('idUsuario', $idUsuario);
            })
            ->whereDate('fecha', '>=', Carbon::today())
            ->whereIn('estado', ['Pendiente', 'Confirmada'])
            ->count();
    }

    // Cantidad de historias clínicas de sus mascotas
    public function TotalHistoriasUsuario(int $idUsuario)
    {
        return DB::table('historiaClinica as hc')
            ->join('mascota as m', 'hc.idMascota', '=', 'm.id')
            ->where('m.idUsuario', $idUsuario)
            ->count();
    }

    // Cantidad de servicios recibidos
    public function TotalServiciosRecibidosUsuario(int $idUsuario)
    {
        return Cita::whereHas('Mascota', function ($query) use ($idUsuario) {
                $query->where('idUsuario', $idUsuario);
            })
            ->where('estado', 'Atendida')
            ->whereNotNull('idServicio')
            ->count();
    }

        
}