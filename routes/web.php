<?php

use App\Http\Controllers\CancelacionCitaController;
use App\Http\Controllers\CitaController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DiagnosticoTratamientoController;
use App\Http\Controllers\EvolucionController;
use App\Http\Controllers\HistoriaClinicaController;
use App\Http\Controllers\HorarioController;
use App\Http\Controllers\MascotaController;
use App\Http\Controllers\ServicioController;
use App\Http\Controllers\UsuarioController;
use App\Http\Controllers\VeterinarioController;
use App\Http\Controllers\MiPerfilController;
use App\Http\Controllers\Seguridad\AuthController;
use App\Http\Controllers\CatalogoMascotaController;
use App\Http\Controllers\MascotaAdopcionController;

Route::get('/', [CatalogoMascotaController::class, 'index'])
    ->name('catalogo.index');

Route::middleware('auth')->group(function () {

    Route::get('/dashboard', [DashboardController::class, 'index'])
            ->name('dashboard.index');

    Route::resource('usuario', UsuarioController::class)->names('usuario')->middleware('modulo:usuario');

    Route::resource('mascota', MascotaController::class)->names('mascota')->middleware('modulo:mascota');

    Route::resource('historiaclinica', HistoriaClinicaController::class)->except(['destroy'])->names('historiaclinica')->middleware('modulo:historiaclinica');

    Route::get(
        '/historiaclinica/{historiaclinica}/pdf',
        [HistoriaClinicaController::class, 'descargarPdf']
    )->name('historiaclinica.pdf')
    ->middleware('modulo:historiaclinica');

    Route::resource('servicio', ServicioController::class)->names('servicio')->middleware('modulo:servicio');

    Route::resource('veterinario', VeterinarioController::class)->names('veterinario')->middleware('modulo:veterinario');

    Route::resource('horario', HorarioController::class)->names('horario')->middleware('modulo:horario');

    // Consultar y registrar citas.
    Route::resource('cita', CitaController::class)
        ->only(['index', 'create', 'store', 'show'])
        ->names('cita')
        ->middleware('modulo:cita');

    // Iniciar la atención veterinaria.
    Route::post('/cita/{id}/iniciar', [CitaController::class, 'iniciarConsulta'])
        ->name('cita.iniciar')
        ->middleware('modulo:cita');

    // Finalizar la consulta veterinaria.
    Route::post('/cita/{id}/finalizar', [CitaController::class, 'finalizarConsulta'])
        ->name('cita.finalizar')
        ->middleware('modulo:cita');

    // Registrar la inasistencia.
    Route::post('/cita/{id}/no-asistio', [CitaController::class, 'marcarNoAsistio'])
        ->name('cita.noAsistio')
        ->middleware('modulo:cita');

    Route::resource('evolucion', EvolucionController::class)->except(['edit', 'update', 'destroy'])->names('evolucion')->middleware('modulo:evolucion');

    Route::resource('diagnosticotratamiento', DiagnosticoTratamientoController::class)->names('diagnosticotratamiento')->middleware('modulo:diagnosticotratamiento');

    Route::resource('cancelacioncita', CancelacionCitaController::class)->only(['store'])->names('cancelacioncita')->middleware('modulo:cancelacioncita');

    /// Mi perfil
    Route::get('/perfil', [MiPerfilController::class, 'index'])
        ->name('perfil.index')
        ->middleware('modulo:perfil');

    Route::get('/perfil/editar', [MiPerfilController::class, 'edit'])
        ->name('perfil.edit')
        ->middleware('modulo:perfil');

    Route::put('/perfil', [MiPerfilController::class, 'update'])
        ->name('perfil.update')
        ->middleware('modulo:perfil');

    Route::post('/perfil/desactivar', [MiPerfilController::class, 'desactivar'])
        ->name('perfil.desactivar')
        ->middleware('modulo:perfil');

});

Route::middleware('guest')->group(function () {
    Route::get('/registro', [AuthController::class, 'showRegistrationForm'])
        ->name('registro');

    Route::post('/registro', [AuthController::class, 'register'])
        ->name('registro.store');
});

// Administración de mascotas del catálogo.
Route::middleware(['auth'])->prefix('admin')->group(function () {
    Route::get('/mascotas-adopcion', [MascotaAdopcionController::class, 'index'])
        ->name('mascotasAdopcion.index');

    Route::get('/mascotas-adopcion/create', [MascotaAdopcionController::class, 'create'])
        ->name('mascotasAdopcion.create');

    Route::post('/mascotas-adopcion', [MascotaAdopcionController::class, 'store'])
        ->name('mascotasAdopcion.store');

    Route::get('/mascotas-adopcion/{id}/edit', [MascotaAdopcionController::class, 'edit'])
        ->name('mascotasAdopcion.edit');

    Route::put('/mascotas-adopcion/{id}', [MascotaAdopcionController::class, 'update'])
        ->name('mascotasAdopcion.update');

    Route::delete('/mascotas-adopcion/{id}', [MascotaAdopcionController::class, 'destroy'])
        ->name('mascotasAdopcion.destroy');
});
