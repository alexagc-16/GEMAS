<?php

namespace App\Services;

use App\Models\Cita;
use App\Models\Horario;
use App\Models\Servicio;
use App\Repository\CitaRepository;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use App\Models\Veterinario;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Models\Role;

class CitaService {

    private CitaRepository $cita_repository;
    private EvolucionService $evolucion_service;
    private DiagnosticoTratamientoService $diagnostico_tratamiento_service;
    private HistoriaClinicaService $historia_clinica_service;

    public function __construct(CitaRepository $citarepository, EvolucionService $evolucionservice,
    DiagnosticoTratamientoService $diagnosticotratamientoservice,
    HistoriaClinicaService $historiaclinicaservice) {
        $this->cita_repository = $citarepository;
        $this->evolucion_service = $evolucionservice;
        $this->diagnostico_tratamiento_service = $diagnosticotratamientoservice;
        $this->historia_clinica_service = $historiaclinicaservice;
    }

    public function listarPaginado(int $porPagina = 10, array $filtros = [])
    {
        return $this->cita_repository->listarPaginado($porPagina, $filtros);
    }

    public function listartodo()
    {
        $usuario = Auth::user();

        // Comprobar si el usuario autenticado tiene el rol de veterinario.
        $esVeterinario = Role::where('name', 'veterinario')
            ->where('activo', true)
            ->whereHas('users', function ($query) use ($usuario) {
                $query->where('model_id', $usuario->id);
            })
            ->exists();

        // Si es veterinario, consultar únicamente sus citas.
        if ($esVeterinario) {

            // Buscar el registro de veterinario asociado a su cuenta.
            $veterinario = Veterinario::where(
                'documentoIdentidad',
                $usuario->documentoIdentidad
            )->first();

            // Si no tiene un registro de veterinario, no mostrar citas.
            if (!$veterinario) {
                return collect();
            }

            return $this->cita_repository->listarPorVeterinario(
                $veterinario->id
            );
        }

        // Administrador y demás usuarios conservan la consulta original.
        return $this->cita_repository->listartodo();
    }

    public function store(array $datos)
    {

        // Primero verificar que exista disponibilidad.
        $this->validarDisponibilidad($datos);

        // Confirmar automáticamente si la validación fue exitosa.
        $datos['estado'] = 'Confirmada';

        $this->cita_repository->store($datos);
    }

    public function edit(int $id)
    {
        return $this->cita_repository->edit($id);
    }

    public function update(int $id,array $datos)
    {

        $cita = $this->cita_repository->edit($id);

        // Define las transiciones de estado permitidas.
        $transicionesPermitidas = [
            'Confirmada' => [
                'En atención',
                'No asistió',
            ],
            'En atención' => [],
            'Atendida' => [],
            'Cancelada' => [],
            'No asistió' => [],
        ];

        // Impide modificar citas que ya tienen un estado final.
        if (in_array($cita->estado, ['Atendida', 'Cancelada', 'No asistió'], true)) {
            throw \Illuminate\Validation\ValidationException::withMessages([
                'estado' => 'No se puede modificar una cita que ya está '
                    . $cita->estado . '.',
            ]);
        }

        // Impedir la modificación de los datos de la cita.
        // Solo se permiten cambios de estado mediante acciones autorizadas.
        $camposPermitidos = ['estado'];

        foreach (array_keys($datos) as $campo) {
            if (!in_array($campo, $camposPermitidos, true)) {
                throw \Illuminate\Validation\ValidationException::withMessages([
                    $campo => 'No se pueden modificar los datos de una cita. Debes crear una nueva.',
                ]);
            }
        }

        // Comprueba si el nuevo estado está permitido.
        if (isset($datos['estado'])) {
            $estadoActual = $cita->estado;
            $nuevoEstado = $datos['estado'];

            if (
                $estadoActual !== $nuevoEstado &&
                !in_array(
                    $nuevoEstado,
                    $transicionesPermitidas[$estadoActual] ?? [],
                    true
                )
            ) {
                throw \Illuminate\Validation\ValidationException::withMessages([
                    'estado' => 'No se puede cambiar la cita de '
                        . $estadoActual . ' a ' . $nuevoEstado . '.',
                ]);
            }

            // Validar las acciones que requieren autorización del veterinario.
            if ($estadoActual !== $nuevoEstado) {

                if ($nuevoEstado === 'En atención') {
                    // Solo el veterinario asignado puede iniciar la atención.
                    $this->validarVeterinarioAsignado($cita);

                    // Verificar que esté dentro de la ventana horaria.
                    $this->validarVentanaAtencion($id);
                }

            }
        }

        $this->cita_repository->update($id, $datos);
    }
    
    public function finalizarConsulta(int $id, array $datos)
    {
        return DB::transaction(function () use ($id, $datos) {

            // Buscar la cita que se va a finalizar.
            $cita = $this->cita_repository->edit($id);

            // Verificar que sea el veterinario asignado a la cita.
            $this->validarVeterinarioAsignado($cita);

            // Solo se puede finalizar una cita en atención.
            if ($cita->estado !== 'En atención') {
                throw ValidationException::withMessages([
                    'estado' => 'Solo se pueden finalizar citas que están en atención.',
                ]);
            }

            // Verificar que el veterinario corresponda a la cita.
            if ((int) $datos['idVeterinario'] !== (int) $cita->idVeterinario) {
                throw ValidationException::withMessages([
                    'idVeterinario' => 'Solo el veterinario asignado a la cita puede registrar la consulta.',
                ]);
            }

            // Obtener la historia clínica de la mascota.
            $historiaClinica = $this->historia_clinica_service
                ->buscarParaConsulta($cita->idMascota);

            // Preparar los datos de la evolución.
            $datosEvolucion = [
                'peso' => $datos['peso'],
                'temperatura' => $datos['temperatura'],
                'sintomas' => $datos['sintomas'],
                'observaciones' => $datos['observaciones'],
                'idHistoriaClinica' => $historiaClinica->id,
                'idVeterinario' => $cita->idVeterinario,
            ];

            // Guardar la evolución y recuperar su identificador.
            $evolucion = $this->evolucion_service->store($datosEvolucion);

            
            // Guardar los diagnósticos y tratamientos asociados.
            foreach ($datos['diagnosticos'] as $registro) {

                // Convertir los campos vacíos en cadenas vacías.
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
                    $registro[$campo] = trim($registro[$campo] ?? '');
                }

                // Asociar el registro con la fecha de la cita y la evolución.
                $registro['fecha'] = $cita->fecha;
                $registro['idEvolucion'] = $evolucion->id;

                $this->diagnostico_tratamiento_service->store($registro);
            }


            // Marcar la cita como atendida cuando todo se haya guardado.
            $this->cita_repository->update($id, [
                'estado' => 'Atendida',
            ]);

            return $evolucion;
        });
    }

    public function marcarNoAsistio(int $id)
    {
        // Buscar la cita.
        $cita = $this->cita_repository->edit($id);

        // Verificar que sea el veterinario asignado.
        $this->validarVeterinarioAsignado($cita);

        // Solo se permite marcar inasistencia en citas confirmadas.
        if ($cita->estado !== 'Confirmada') {
            throw ValidationException::withMessages([
                'estado' => 'Solo se pueden marcar como No asistió las citas confirmadas.',
            ]);
        }

        // Verificar que la cita esté dentro de su ventana horaria.
        $this->validarVentanaNoAsistencia($cita);

        // Actualizar el estado de la cita.
        $this->cita_repository->update($id, [
            'estado' => 'No asistió',
        ]);
    }

    public function destroy(int $id)
    {
        throw \Illuminate\Validation\ValidationException::withMessages([
            'cita' => 'Las citas no se pueden eliminar. Si necesitas otra cita, debes crear una nueva.',
        ]);
    }

    private function validarDisponibilidad(array $datos, ?int $idCita = null): void
    {
        $fecha = Carbon::parse($datos['fecha']);

        // Obtener el día de la semana en español.
        $dias = [
            0 => 'Domingo',
            1 => 'Lunes',
            2 => 'Martes',
            3 => 'Miercoles',
            4 => 'Jueves',
            5 => 'Viernes',
            6 => 'Sabado',
        ];

        $diaSemana = $dias[$fecha->dayOfWeek];

        // Buscar el horario del veterinario para ese día.
        $horarios = Horario::where(
            'idVeterinario',
            $datos['idVeterinario']
        )->get();

        $horario = $horarios->first(function ($item) use ($diaSemana) {
            return Str::lower(Str::ascii($item->diaSemana))
                === Str::lower(Str::ascii($diaSemana));
        });

        if (!$horario) {
            throw ValidationException::withMessages([
                'hora' => 'El veterinario no tiene horario registrado para ese día.',
            ]);
        }

        // Obtener la duración del servicio.
        $servicio = Servicio::findOrFail($datos['idServicio']);

        $duracion = (int) $servicio->duracionMinutos;

        if ($duracion <= 0) {
            throw ValidationException::withMessages([
                'idServicio' => 'El servicio seleccionado no tiene una duración válida.',
            ]);
        }

        // Calcular inicio y fin de la cita.
        $inicioCita = Carbon::parse(
            $datos['fecha'] . ' ' . $datos['hora']
        );

        $finCita = $inicioCita->copy()->addMinutes($duracion);

        // Comprobar que la cita quede dentro de la jornada.
        $inicioJornada = Carbon::parse(
            $datos['fecha'] . ' ' . $horario->horaInicio
        );

        $finJornada = Carbon::parse(
            $datos['fecha'] . ' ' . $horario->horaFin
        );

        if (
            $inicioCita->lt($inicioJornada) ||
            $finCita->gt($finJornada)
        ) {
            throw ValidationException::withMessages([
                'hora' => 'La cita debe estar dentro del horario laboral del veterinario y terminar antes de finalizar la jornada.',
            ]);
        }

        // Comprobar si la cita se cruza con el almuerzo.
        if (
            $horario->horaAlmuerzoInicio &&
            $horario->horaAlmuerzoFin
        ) {
            $inicioAlmuerzo = Carbon::parse(
                $datos['fecha'] . ' ' . $horario->horaAlmuerzoInicio
            );

            $finAlmuerzo = Carbon::parse(
                $datos['fecha'] . ' ' . $horario->horaAlmuerzoFin
            );

            if (
                $inicioCita->lt($finAlmuerzo) &&
                $finCita->gt($inicioAlmuerzo)
            ) {
                throw ValidationException::withMessages([
                    'hora' => 'La cita se cruza con el horario de almuerzo del veterinario.',
                ]);
            }
        }

        // Consultar las citas que ocupan el horario del veterinario.
        $citasExistentes = Cita::with('Servicio')
            ->whereDate('fecha', $datos['fecha'])
            ->where('idVeterinario', $datos['idVeterinario'])
            ->whereIn('estado', [
                'Confirmada',
                'En atención',
            ])
            ->when($idCita !== null, function ($query) use ($idCita) {
                $query->where('id', '!=', $idCita);
            })
            ->get();

        foreach ($citasExistentes as $citaExistente) {
            if (!$citaExistente->Servicio) {
                continue;
            }

            $duracionExistente = (int)
                $citaExistente->Servicio->duracionMinutos;

            if ($duracionExistente <= 0) {
                continue;
            }

            $inicioExistente = Carbon::parse(
                $citaExistente->fecha . ' ' . $citaExistente->hora
            );

            $finExistente = $inicioExistente->copy()
                ->addMinutes($duracionExistente);

            // Detectar el cruce entre las dos citas.
            if (
                $inicioCita->lt($finExistente) &&
                $finCita->gt($inicioExistente)
            ) {
                throw ValidationException::withMessages([
                    'hora' => 'El veterinario ya tiene una cita que se cruza con ese horario.',
                ]);
            }
        }
    }

    public function validarVentanaAtencion(int $id)
    {
        $cita = $this->cita_repository->edit($id);

        $servicio = Servicio::findOrFail($cita->idServicio);
        $duracion = (int) $servicio->duracionMinutos;

        if ($duracion <= 0) {
            throw ValidationException::withMessages([
                'hora' => 'El servicio no tiene una duración válida configurada.',
            ]);
        }

        $inicio = Carbon::parse($cita->fecha . ' ' . $cita->hora);
        $fin = $inicio->copy()->addMinutes($duracion);
        $ahora = now();

        if ($ahora->lt($inicio) || $ahora->gte($fin)) {
            throw ValidationException::withMessages([
                'hora' => 'Solo puedes iniciar la atención desde la hora programada y antes de que finalice la duración del servicio.',
            ]);
        }
    }

    private function validarVentanaNoAsistencia(Cita  $cita)
    {
        // Obtener la duración del servicio.
        $duracion = (int) ($cita->Servicio?->duracionMinutos ?? 0);

        if ($duracion <= 0) {
            throw ValidationException::withMessages([
                'estado' => 'No se puede registrar la inasistencia porque el servicio no tiene una duración válida.',
            ]);
        }

        // Fecha y hora de inicio de la cita.
        $inicio = Carbon::parse(
            $cita->fecha . ' ' . $cita->hora
        );

        // Momento desde el que se permite registrar la inasistencia.
        $inicioPermitido = $inicio->copy()->addMinutes(15);

        // Finalización del servicio.
        $fin = $inicio->copy()->addMinutes($duracion);

        // Hora actual.
        $ahora = now();

        // Antes de los primeros 15 minutos.
        if ($ahora->lt($inicioPermitido)) {
            throw ValidationException::withMessages([
                'estado' => 'Aún no se puede registrar la inasistencia. Deben transcurrir 15 minutos desde el inicio de la cita.',
            ]);
        }

        // Después de finalizar el servicio.
        if ($ahora->gt($fin)) {
            throw ValidationException::withMessages([
                'estado' => 'No se puede registrar la inasistencia porque el tiempo del servicio ya finalizó.',
            ]);
        }
    }

    public function validarVeterinarioAsignado(Cita $cita): void
    {
        $usuario = Auth::user();

        if (!$usuario) {
            abort(403, 'Debes iniciar sesión.');
        }

        // Comprobar que tenga el rol veterinario activo.
        $esVeterinario = Role::where('name', 'veterinario')
            ->where('activo', true)
            ->whereHas('users', function ($query) use ($usuario) {
                $query->where('model_id', $usuario->id);
            })
            ->exists();

        if (!$esVeterinario) {
            abort(403, 'Solo el veterinario asignado puede acceder a esta consulta.');
        }

        // Buscar el registro de veterinario asociado a la cuenta.
        $veterinario = Veterinario::where(
            'documentoIdentidad',
            $usuario->documentoIdentidad
        )->first();

        if (
            !$veterinario ||
            (int) $veterinario->id !== (int) $cita->idVeterinario
        ) {
            abort(403, 'No tienes autorización para atender esta cita.');
        }
    }
}