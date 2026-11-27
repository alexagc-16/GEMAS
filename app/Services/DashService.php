<?php

namespace App\Services;

use App\Repository\DashRepository;

class DashService{
    
    private DashRepository $dash_repository;

    public function __construct(DashRepository $dashrepository) {
        $this->dash_repository = $dashrepository;
    }

    public function TotalMascotas(){
        return $this->dash_repository->TotalMascotas();
    }

    public function TotalUsuarios(){
        return $this->dash_repository->TotalUsuarios();
    }

    public function TotalCitasHoy(){
        return $this->dash_repository->TotalCitasHoy();
    }    

    public function TotalCitasMes(){
        return $this->dash_repository->TotalCitasMes();
    }  

    public function CitasDelDia(){
        return $this->dash_repository->CitasDelDia();
    }

    public function ProximasCitas(){
        return $this->dash_repository->ProximasCitas();
    }

    public function CitasPorMes()
    {
        return $this->dash_repository->CitasPorMes();
    }

    public function ServiciosMasSolicitados(){
        return $this->dash_repository->ServiciosMasSolicitados();
    }
    
    // Buscar veterinario
    public function VeterinarioPorDocumento(string $documentoIdentidad)
    {
        return $this->dash_repository
            ->VeterinarioPorDocumento($documentoIdentidad);
    }

    // Citas de hoy
    public function CitasHoyVeterinario(int $idVeterinario)
    {
        return $this->dash_repository
            ->CitasHoyVeterinario($idVeterinario);
    }

    // Citas del mes
    public function CitasMesVeterinario(int $idVeterinario)
    {
        return $this->dash_repository
            ->CitasMesVeterinario($idVeterinario);
    }

    // Listado de historias pendientes por completar
    public function HistoriasPendientesVeterinario()
    {
        return $this->dash_repository->HistoriasPendientesVeterinario();
    }

    // Total de historias pendientes por completar
    public function TotalHistoriasPendientesVeterinario()
    {
        return $this->dash_repository->TotalHistoriasPendientesVeterinario();
    }

    // Citas por estado
    public function CitasPorEstadoVeterinario(int $idVeterinario)
    {
        $datos = $this->dash_repository
            ->CitasPorEstadoVeterinario($idVeterinario);

        $totalCitas = array_sum($datos);

        $actividad = [];

        foreach ($datos as $estado => $cantidad) {

            $actividad[] = [
                'nombre' => $estado,
                'total' => $cantidad,
                'porcentaje' => $totalCitas > 0
                    ? round(($cantidad / $totalCitas) * 100, 1)
                    : 0,
            ];
        }

        return $actividad;
    }

    // Mascotas del usuario
    public function MascotasUsuario(int $idUsuario)
    {
        return $this->dash_repository->MascotasUsuario($idUsuario);
    }

    // Próximas citas
    public function ProximasCitasUsuario(int $idUsuario)
    {
        return $this->dash_repository->ProximasCitasUsuario($idUsuario);
    }

    // Servicios recibidos
    public function ServiciosRecibidosUsuario(int $idUsuario)
    {
        return $this->dash_repository->ServiciosRecibidosUsuario($idUsuario);
    }

    // Total de mascotas
    public function TotalMascotasUsuario(int $idUsuario)
    {
        return $this->dash_repository->TotalMascotasUsuario($idUsuario);
    }

    // Total de próximas citas
    public function TotalProximasCitasUsuario(int $idUsuario)
    {
        return $this->dash_repository->TotalProximasCitasUsuario($idUsuario);
    }

    // Total de historias clínicas
    public function TotalHistoriasUsuario(int $idUsuario)
    {
        return $this->dash_repository->TotalHistoriasUsuario($idUsuario);
    }

    // Total de servicios recibidos
    public function TotalServiciosRecibidosUsuario(int $idUsuario)
    {
        return $this->dash_repository->TotalServiciosRecibidosUsuario($idUsuario);
    }
}
