<?php

namespace App\Http\Controllers;

use App\Services\MascotaAdopcionService;
use Illuminate\Http\Request;

class CatalogoMascotaController extends Controller
{
    
    private MascotaAdopcionService $mascota_adopcion_service;

    public function __construct(MascotaAdopcionService $mascotaadopcionservice) {
        $this->mascota_adopcion_service = $mascotaadopcionservice;
    }

    public function index()
    {
        $mascotas = $this->mascota_adopcion_service->listarEnAdopcion();
        return view('Catalogo.index', compact('mascotas'));
    }
}