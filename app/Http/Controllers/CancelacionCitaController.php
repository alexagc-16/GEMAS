<?php

namespace App\Http\Controllers;

use App\Http\Requests\CancelacionCitaStoreRequest;
use App\Models\CancelacionCita;
use App\Services\CancelacionCitaService;
use App\Services\CitaService;
use Illuminate\Http\Request;

class CancelacionCitaController extends Controller
{
    private CancelacionCitaService $cancelacion_cita_service;

    public function __construct(CancelacionCitaService $cancelacioncitaservice)
    {
        $this->cancelacion_cita_service = $cancelacioncitaservice;
    }

    /**
     * Registra la cancelación de una cita.
     */
    public function store(CancelacionCitaStoreRequest $request)
    {
        $datos = $request->validated();

        // El servicio identifica el rol y valida los permisos del cancelador.
        $this->cancelacion_cita_service->cancelar(
            (int) $datos['idCita'],
            $datos['motivo']
        );

        return redirect()
            ->route('cita.index')
            ->with('success', 'La cita se canceló correctamente.');
    }
}
