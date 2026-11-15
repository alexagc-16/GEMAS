<?php

namespace App\Http\Controllers;

use App\Http\Requests\HistoriaClinicaStoreRequest;
use App\Models\HistoriaClinica;
use App\Services\HistoriaClinicaService;
use App\Services\MascotaService;
use Illuminate\Http\Request;
use App\Models\Usuario;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Str;

class HistoriaClinicaController extends Controller
{

    private HistoriaClinicaService $historia_clinica_service;
    private MascotaService $mascota_service;

    public function __construct(HistoriaClinicaService $historiaclinicaservice, MascotaService $mascotaservice) {
        $this->historia_clinica_service = $historiaclinicaservice;
        $this->mascota_service = $mascotaservice;
    }
    
    public function index(Request $request)
    {
        /** @var Usuario $usuario */
        $usuario = Auth::user();

        // Obtener los filtros enviados desde el formulario.
        $filtros = [
            'buscar' => $request->input('buscar'),
            'fecha' => $request->input('fecha'),
            'estado' => $request->input('estado'),
        ];

        // Evitar enviar valores vacíos al repositorio.
        $filtros = array_filter($filtros, function ($valor) {
            return $valor !== null && $valor !== '';
        });

        if ($usuario->tieneRolActivo('usuario')) {
            $historiasClinicas = $this->historia_clinica_service
                ->listarPaginadoPorUsuario($usuario->id, 10, $filtros);
        } else {
            $historiasClinicas = $this->historia_clinica_service
                ->listarPaginado(10, $filtros);
        }

        // Conservar los filtros al cambiar de página.
        $historiasClinicas->appends($request->query());

        return view('HistoriaClinica.index', compact('historiasClinicas'));
    }
    
    public function create()
    {
        $historiasClinicas = $this->historia_clinica_service->listarPendientes();

        return view('HistoriaClinica.create', compact('historiasClinicas'));
    }

    public function store(HistoriaClinicaStoreRequest $request)
    {
        $this->historia_clinica_service->store($request->validated());
        return redirect()->route('historiaclinica.index')->with('sucess', 'Historia clinica creada correctamente');
    }

    public function show()
    {
        //
    }

    public function edit(int $id)
    {
        $historiaClinica = $this->historia_clinica_service->edit($id);

        // Evitar modificar una historia clínica ya completada
        if ($historiaClinica->completadaEn !== null) {
            return redirect()
                ->route('historiaclinica.index')
                ->with('error', 'Esta historia clínica ya fue completada y no se puede modificar.');
        }

        return view('HistoriaClinica.update', compact('historiaClinica'));
    }

    public function update(int $id, HistoriaClinicaStoreRequest $request)
    {
        $this->historia_clinica_service->update($id, $request->validated());
        return redirect()->route('historiaclinica.index')->with('update', 'Historia clinica actualizada correctamente');
    }

    public function descargarPdf(int $id)
    {
        $historiaClinica = $this->historia_clinica_service
            ->buscarParaPdf($id);

        /** @var Usuario $usuario */
        $usuario = Auth::user();

        // El usuario solo puede descargar historias de sus propias mascotas.
        if (
            $usuario->tieneRolActivo('usuario') &&
            (int) $historiaClinica->Mascota->idUsuario !== (int) $usuario->id
        ) {
            abort(403, 'No tienes permiso para descargar esta historia clínica.');
        }

        $pdf = Pdf::loadView('HistoriaClinica.pdf', [
            'historiaClinica' => $historiaClinica
        ])->setPaper('a4', 'portrait');

        $nombreMascota = Str::slug(
            $historiaClinica->Mascota->nombre ?? 'mascota'
        );

        return $pdf->download("historia-clinica-{$nombreMascota}.pdf");
    }
}

