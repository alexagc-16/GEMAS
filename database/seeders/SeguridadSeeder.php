<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

class SeguridadSeeder extends Seeder
{
    public function run(): void
    {
        // Limpiar caché de permisos de Spatie
        app(PermissionRegistrar::class)->forgetCachedPermissions();

        $guard = config('seguridad.guard');

        // Crear los roles del sistema
        $rolAdmin = Role::firstOrCreate(
            ['name' => config('seguridad.rol_admin'), 'guard_name' => $guard],
            ['activo' => true]
        );

        $rolUsuario = Role::firstOrCreate(
            ['name' => 'usuario', 'guard_name' => $guard],
            ['activo' => true]
        );

        $rolVeterinario = Role::firstOrCreate(
            ['name' => 'veterinario', 'guard_name' => $guard],
            ['activo' => true]
        );

        // Mantener activo el rol administrador
        $rolAdmin->update(['activo' => true]);

        // Crear permiso para gestionar la seguridad
        $permisoAdmin = Permission::firstOrCreate(
            [
                'name' => config('seguridad.permiso_admin'),
                'guard_name' => $guard,
            ],
            ['modulo' => 'seguridad']
        );

        if ($permisoAdmin->modulo === null) {
            $permisoAdmin->update(['modulo' => 'seguridad']);
        }

        // Obtener la configuración de permisos por rol
        $permisosPorRol = config('seguridad.permisos_por_rol', []);
        $roles = [
            'usuario' => $rolUsuario,
            'veterinario' => $rolVeterinario,
        ];

        // Obtener todos los módulos definidos para los roles
        $modulos = collect($permisosPorRol)
            ->except(config('seguridad.rol_admin'))
            ->flatMap(fn ($permisos) => array_keys($permisos))
            ->reject(fn ($modulo) => $modulo === '*')
            ->unique()
            ->values();

        // Crear los permisos estándar de cada módulo
        foreach ($modulos as $modulo) {

            foreach (config('seguridad.acciones', []) as $accion) {

                $permiso = Permission::firstOrCreate(
                    [
                        'name' => $accion . ' ' . $modulo,
                        'guard_name' => $guard,
                    ],
                    ['modulo' => $modulo]
                );

                if ($permiso->modulo === null) {
                    $permiso->update(['modulo' => $modulo]);
                }
            }
        }

        // Asignar los permisos definidos a usuario y veterinario
        foreach ($roles as $nombreRol => $rol) {

            $permisosDelRol = $permisosPorRol[$nombreRol] ?? [];

            foreach ($permisosDelRol as $modulo => $acciones) {

                foreach ($acciones as $accion) {

                    $permiso = Permission::where('name', $accion . ' ' . $modulo)
                        ->where('guard_name', $guard)
                        ->first();

                    if ($permiso) {
                        $rol->givePermissionTo($permiso);
                    }
                }
            }
        }

        // Crear y asignar los permisos especiales
        $permisosEspeciales = config('seguridad.permisos_especiales_por_rol', []);

        foreach ($permisosEspeciales as $nombreRol => $nombresPermisos) {

            $rol = $roles[$nombreRol] ?? null;

            if (! $rol) {
                continue;
            }

            foreach ($nombresPermisos as $nombrePermiso) {

                $modulo = str($nombrePermiso)->after(' ')->toString();

                $permiso = Permission::firstOrCreate(
                    [
                        'name' => $nombrePermiso,
                        'guard_name' => $guard,
                    ],
                    ['modulo' => $modulo]
                );

                if ($permiso->modulo === null) {
                    $permiso->update(['modulo' => $modulo]);
                }

                $rol->givePermissionTo($permiso);
            }
        }

        // Asignar todos los permisos al administrador
        $rolAdmin->syncPermissions(
            Permission::where('guard_name', $guard)->get()
        );

        // Obtener el modelo de usuario configurado
        $modelo = config('auth.providers.users.model');
        $datos = config('seguridad.admin');

        // Crear o buscar el usuario administrador
        $admin = $modelo::firstOrCreate(
            ['email' => $datos['email']],
            [
                'nombre' => $datos['nombre'] ?? 'Administrador',
                'apellido' => $datos['apellido'] ?? 'Sistema',
                'documentoIdentidad' => $datos['documentoIdentidad'] ?? '00000000',
                'telefono' => $datos['telefono'] ?? '000000000',
                'direccion' => $datos['direccion'] ?? 'N/A',
                'password' => Hash::make($datos['password']),
            ]
        );

        // Asignar el rol administrador
        $admin->assignRole($rolAdmin);

        // Limpiar caché nuevamente
        app(PermissionRegistrar::class)->forgetCachedPermissions();
    }
}