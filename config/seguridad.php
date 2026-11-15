<?php

return [
    'guard' => 'web',

    'rol_admin' => 'administrador',

    'permiso_admin' => 'gestionar seguridad',

    'roles_protegidos' => ['administrador'],

    'roles_no_desactivables' => ['administrador'],

    'acciones' => ['ver', 'crear', 'editar', 'eliminar'],

    'metodos_a_acciones' => [
        'index' => 'ver',
        'show' => 'ver',
        'create' => 'crear',
        'store' => 'crear',
        'edit' => 'editar',
        'update' => 'editar',
        'destroy' => 'eliminar',

        // Acciones especiales de las citas
        'iniciarConsulta' => 'editar',
        'finalizarConsulta' => 'editar',
        'marcarNoAsistio' => 'editar',

        // Acciones especiales de historias clínicas
        'descargarPdf' => 'ver',
    ],

    'permisos_por_rol' => [

        'administrador' => [
            '*' => ['*'],
        ],

        'usuario' => [
            'perfil' => ['ver', 'editar'],
            'mascota' => ['ver', 'crear', 'editar'],
            'historiaclinica' => ['ver'],
            'servicio' => ['ver'],
            'veterinario' => ['ver'],
            'horario' => ['ver'],
            'cita' => ['ver', 'crear'],
            'cancelacioncita' => ['crear'],
        ],

        'veterinario' => [
            'perfil' => ['ver', 'editar'],
            'mascota' => ['ver', 'crear', 'editar'],
            'historiaclinica' => ['ver', 'crear', 'editar'],
            'servicio' => ['ver'],
            'horario' => ['ver', 'crear', 'editar', 'eliminar'],
            'cita' => ['ver', 'editar'],
            'cancelacioncita' => ['crear'],
        ],

    ],

    'permisos_especiales_por_rol' => [
        'usuario' => [
            'crear cancelacioncita',
            'desactivar perfil'
        ],

        'veterinario' => [
            'crear cancelacioncita',
        ],
    ],

    'auditar_prefijos' => ['App\\'],

    'redirect_despues_login' => '/dashboard',

    'admin' => [
        'name' => env('SEGURIDAD_ADMIN_NAME', 'Administrador'),
        'email' => env('SEGURIDAD_ADMIN_EMAIL', 'admin@admin.com'),
        'password' => env('SEGURIDAD_ADMIN_PASSWORD', '12345678'),
    ],
];
