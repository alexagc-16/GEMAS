<?php

use App\Http\Controllers\Seguridad\AuthController;
use App\Http\Controllers\Seguridad\CuentaController;
use App\Http\Controllers\Seguridad\PermisoController;
use App\Http\Controllers\Seguridad\RolController;
use App\Http\Controllers\Seguridad\UsuarioRolController;
use App\Http\Controllers\Seguridad\CambiarPasswordController;
use App\Http\Controllers\Seguridad\RestablecerPasswordController;
use App\Http\Controllers\Seguridad\RecuperarPasswordController;
use Illuminate\Support\Facades\Route;

Route::middleware('web')->group(function () {

    Route::middleware('guest')->group(function () {
        Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
        Route::post('/login', [AuthController::class, 'login'])
            ->middleware('throttle:5,1')
            ->name('login.store');

        // Mostrar formulario para establecer contraseña
        Route::get('/restablecerpassword/{token}', [
            RestablecerPasswordController::class,
            'create'
        ])->name('password.reset');

        // Guardar nueva contraseña
        Route::post('/restablecerpassword', [
            RestablecerPasswordController::class,
            'store'
        ])->name('password.update');

        // Recuperación de contraseña mediante código
        Route::get('/recuperar-password', [
            RecuperarPasswordController::class,
            'create'
        ])->name('password.request');

        Route::post('/recuperar-password/codigo', [
            RecuperarPasswordController::class,
            'enviarCodigo'
        ])->middleware('throttle:3,1')->name('password.codigo.enviar');

        Route::get('/recuperar-password/verificar', [
            RecuperarPasswordController::class,
            'mostrarVerificacion'
        ])->name('password.codigo.form');

        Route::post('/recuperar-password/verificar', [
            RecuperarPasswordController::class,
            'verificarCodigo'
        ])->middleware('throttle:5,1')->name('password.codigo.verificar');

        Route::get('/recuperar-password/nueva', [
            RecuperarPasswordController::class,
            'mostrarNuevaPassword'
        ])->name('password.nueva.form');

        Route::post('/recuperar-password/nueva', [
            RecuperarPasswordController::class,
            'actualizarPassword'
        ])->name('password.nueva.actualizar');
    });

    Route::middleware('auth')->group(function () {
        Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

        // Rutas disponibles para los tres roles
        Route::prefix('seguridad')
            ->name('seguridad.')
            ->group(function () {

                Route::get('/cambiarpassword', [
                    CambiarPasswordController::class,
                    'edit'
                ])->name('password.edit');

                Route::put('/cambiarpassword', [
                    CambiarPasswordController::class,
                    'update'
                ])->name('password.update');

            });

        // Rutas exclusivas del administrador
        Route::prefix('seguridad')
            ->name('seguridad.')
            ->middleware('can:' . config('seguridad.permiso_admin'))
            ->group(function () {

                Route::get('/roles', [RolController::class, 'index'])->name('roles.index');
                Route::get('/roles/crear', [RolController::class, 'create'])->name('roles.create');
                Route::post('/roles', [RolController::class, 'store'])->name('roles.store');
                Route::get('/roles/{rol}/editar', [RolController::class, 'edit'])->name('roles.edit');
                Route::put('/roles/{rol}', [RolController::class, 'update'])->name('roles.update');
                Route::patch('/roles/{rol}/estado', [RolController::class, 'estado'])->name('roles.estado');
                Route::delete('/roles/{rol}', [RolController::class, 'destroy'])->name('roles.destroy');

                Route::get('/permisos', [PermisoController::class, 'index'])->name('permisos.index');
                Route::post('/permisos', [PermisoController::class, 'store'])->name('permisos.store');
                Route::post('/permisos/modulo', [PermisoController::class, 'storeModulo'])->name('permisos.modulo');
                Route::put('/permisos/{permiso}', [PermisoController::class, 'update'])->name('permisos.update');
                Route::delete('/permisos/{permiso}', [PermisoController::class, 'destroy'])->name('permisos.destroy');

                // Gestión de cuentas
                Route::resource('cuentas', CuentaController::class)
                    ->except(['destroy', 'show'])
                    ->names('cuentas');

                Route::post('/cuentas/{cuenta}/desactivar', [CuentaController::class, 'desactivar'])
                    ->name('cuentas.desactivar');

                Route::post('/cuentas/{cuenta}/reactivar', [CuentaController::class, 'reactivar'])
                    ->name('cuentas.reactivar');

                Route::get('/usuarios', [UsuarioRolController::class, 'index'])->name('usuarios.index');
                Route::put('/usuarios', [UsuarioRolController::class, 'update'])->name('usuarios.update');

            });
    
        });
});
