<?php

namespace App\Services;

use App\Models\Cita;
use App\Repository\CancelacionCitaRepository;
use Carbon\Carbon;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class CancelacionCitaService{

    private CancelacionCitaRepository $cancelacion_cita_repository;

    public function __construct(CancelacionCitaRepository $cancelacioncitarepository) {
        $this->cancelacion_cita_repository = $cancelacioncitarepository;
    }

    public function listartodo(){
        return $this->cancelacion_cita_repository->listartodo();
    }

    public function edit(int $id)
    {
        return $this->cancelacion_cita_repository->edit($id);
    }

    /**
     * Registra la cancelación y actualiza el estado de la cita.
     */
    public function cancelar(int $idCita, ?string $motivo = null)
    {
        return DB::transaction(function () use ($idCita, $motivo) {

            // Bloquea la cita mientras se procesa la cancelación.
            $cita = Cita::whereKey($idCita)
                ->lockForUpdate()
                ->firstOrFail();

            $usuario = request()->user();

            if (!$usuario) {
                throw new AuthorizationException('Debes iniciar sesión para cancelar una cita.');
            }

            // Solo se pueden cancelar citas que todavía estén confirmadas.
            if ($cita->estado !== 'Confirmada') {
                throw ValidationException::withMessages([
                    'cancelacion' => 'Solo se pueden cancelar citas confirmadas.',
                ]);
            }

            // Determina el tipo de cancelador según sus roles activos.
            if ($usuario->hasRole('administrador')) {

                $tipoCancelador = 'Administrador';

            } elseif ($usuario->hasRole('veterinario')) {

                // Comprueba que el veterinario sea quien tiene asignada la cita.
                if (!$cita->Veterinario ||
                    $cita->Veterinario->documentoIdentidad !== $usuario->documentoIdentidad) {
                    throw new AuthorizationException('No puedes cancelar una cita que no tienes asignada.');
                }

                $tipoCancelador = 'Veterinario';

            } elseif ($usuario->hasRole('usuario')) {

                // Comprueba que la mascota pertenezca al usuario autenticado.
                if (!$cita->Mascota || $cita->Mascota->idUsuario !== $usuario->id) {
                    throw new AuthorizationException('No puedes cancelar una cita que no pertenece a tus mascotas.');
                }

                // El usuario debe cancelar con al menos tres horas de anticipación.
                $fechaHoraCita = Carbon::parse($cita->fecha . ' ' . $cita->hora);

                if (now()->greaterThanOrEqualTo($fechaHoraCita->copy()->subHours(3))) {
                    throw ValidationException::withMessages([
                        'cancelacion' => 'Debes cancelar con al menos 3 horas de anticipación. Comunícate con la clínica si necesitas cancelar fuera de ese plazo.',
                    ]);
                }

                $tipoCancelador = 'Usuario';

            } else {
                throw new AuthorizationException('No tienes permiso para cancelar citas.');
            }

            // Elimina espacios al inicio y al final del motivo.
            $motivo = trim($motivo ?? '');

            // Todos los canceladores deben indicar un motivo.
            if ($motivo === '') {
                throw ValidationException::withMessages([
                    'motivo' => 'Debes indicar el motivo de la cancelación.',
                ]);
            }
            
            // Guarda quién canceló, el motivo y la fecha de cancelación.
            $cancelacionCita = $this->cancelacion_cita_repository->store([
                'idCita' => $cita->id,
                'tipoCancelador' => $tipoCancelador,
                'motivo' => trim($motivo),
                'fechaCancelacion' => now(),
            ]);

            // Actualiza el estado únicamente después de registrar la cancelación.
            $cita->estado = 'Cancelada';
            $cita->save();

            return $cancelacionCita;
        });
    }
}