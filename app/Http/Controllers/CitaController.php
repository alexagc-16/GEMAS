<?php

namespace App\Http\Controllers;

use App\Http\Requests\CitaStoreRequest;
use App\Http\Requests\FinalizarConsultaRequest;
use App\Models\Cita;
use App\Services\CitaService;
use App\Services\HistoriaClinicaService;
use App\Services\MascotaService;
use App\Services\ServicioService;
use App\Services\VeterinarioService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Models\Usuario;

class CitaController extends Controller
{

    private CitaService $cita_service;
    private MascotaService $mascota_service;
    private VeterinarioService $veterinario_service;
    private ServicioService $servicio_service;
    private HistoriaClinicaService $historia_clinica_service;

    public function __construct(CitaService $citaservice, MascotaService $mascotaservice, VeterinarioService $veterinarioservice, ServicioService $servicioservice, HistoriaClinicaService $historiaclinicaservice) {
        $this->cita_service = $citaservice;
        $this->mascota_service = $mascotaservice;
        $this->veterinario_service = $veterinarioservice;
        $this->servicio_service = $servicioservice;
        $this->historia_clinica_service = $historiaclinicaservice;
    }

    public function index()
    {
        $citas = $this->cita_service->listarPaginado(10);
        return view('Cita.index', compact('citas'));
    }

    public function create()
    {
        /** @var Usuario $usuario */
        $usuario = Auth::user();

        if ($usuario->tieneRolActivo('usuario')) {
            $mascotas = $this->mascota_service->listarPorUsuario($usuario->id);
        } else {
            $mascotas = $this->mascota_service->listartodo();
        }

        $veterinarios = $this->veterinario_service->listartodo();
        $servicios = $this->servicio_service->listarTodo();

        return view('Cita.create', compact('mascotas', 'veterinarios', 'servicios'));
    }

    public function store(CitaStoreRequest $request)
    {
        $this->cita_service->store($request->validated());
        return redirect()->route('cita.index')->with('success', 'Cita creada correctamente');
    }

    public function show(int $id)   
    {
        // Buscar la cita seleccionada.
        $cita = $this->cita_service->edit($id);

        // Solo el veterinario asignado puede acceder a la consulta.
        $this->cita_service->validarVeterinarioAsignado($cita);

        // Solo se puede iniciar o continuar una cita
        // confirmada o que ya esté en atención.
        if (!in_array($cita->estado, ['Confirmada', 'En atención'], true)) {
            abort(403, 'Esta cita no se puede atender.');
        }

        // Validar la ventana horaria únicamente al iniciar.
        if ($cita->estado === 'Confirmada') {
            $this->cita_service->validarVentanaAtencion($id);
        }

        // Obtener la historia clínica completa de la mascota.
        $historiaClinica = $this->historia_clinica_service
            ->buscarParaConsulta($cita->idMascota);

        // Cambiar el estado al iniciar la atención.
        if ($cita->estado === 'Confirmada') {
            $this->cita_service->update($id, [
                'estado' => 'En atención',
            ]);

            $cita = $this->cita_service->edit($id);
        }

        // Mostrar la historia clínica desde la cita.
        return view('HistoriaClinica.consulta', compact('cita','historiaClinica'));
    }
        
    public function edit(int $id)
    {
        $cita = $this->cita_service->edit($id);
        $mascotas = $this->mascota_service->listartodo();
        $veterinarios = $this->veterinario_service->listartodo();
        $servicios = $this->servicio_service->listarTodo();
        return view('Cita.update', compact('cita','mascotas', 'veterinarios', 'servicios'));
    }
    
    public function update(FinalizarConsultaRequest $request, int $id)
    {
        // Obtener los datos enviados para identificar la acción.
        $accion = $request->input('accion');

        // Finalizar la consulta veterinaria.
        if ($accion === 'finalizar_consulta') {

            $datos = $request->validated();

            $this->cita_service->finalizarConsulta($id, $datos);

            return redirect()
                ->route('cita.index')
                ->with('success', 'Consulta finalizada correctamente.');
        }

        // Registrar que la mascota no asistió.
        if ($accion === 'no_asistio') {

            $this->cita_service->marcarNoAsistio($id);

            return redirect()
                ->route('cita.index')
                ->with('success', 'La cita se marcó como No asistió correctamente.');
        }

        abort(403, 'Las citas no se pueden editar. Debes crear una nueva.');
    }

    public function finalizarConsulta(int $id,FinalizarConsultaRequest $request)
    {
        $this->cita_service->finalizarConsulta($id, $request->validated());

        return redirect()->route('cita.index')->with('success', 'Consulta finalizada correctamente.');
    }

    public function destroy(int $id)
    {
        $this->cita_service->destroy($id);
        return redirect()->route('cita.index')->with('destroy', 'Cita eliminada correctamente');
    }

    private function validarDiagnosticos($validador, Request $request): void
    {
        $validador->after(function ($validador) use ($request) {
            $registros = $request->input('diagnosticos', []);
            $hayInformacion = false;

            foreach ($registros as $registro) {
                foreach ([
                    'diagnostico',
                    'tratamiento',
                    'medicamento',
                    'dosis',
                    'frecuencia',
                    'duracion',
                    'procedimiento',
                    'examenOrdenado',
                    'indicaciones',
                ] as $campo) {
                    if (trim($registro[$campo] ?? '') !== '') {
                        $hayInformacion = true;
                        break 2;
                    }
                }
            }

            if (!$hayInformacion) {
                $validador->errors()->add(
                    'diagnosticos',
                    'Registra al menos un diagnóstico, tratamiento, medicamento, procedimiento, examen o indicación.'
                );
            }
        });
    }

    public function marcarNoAsistio(int $id)
    {
        // Registrar la inasistencia mediante el servicio.
        $this->cita_service->marcarNoAsistio($id);

        return redirect()
            ->route('cita.index')
            ->with('success', 'La cita se marcó como No asistió correctamente.');
    }

}
