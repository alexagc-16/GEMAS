@extends('layouts.app')

@section('title')
    Usuarios - Gemas
@endsection

@section('content')

    <div class="w-full max-w-7xl mx-auto space-y-6">

        {{-- Encabezado --}}
        <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <h1 class="text-2xl font-bold text-slate-800">
                    Usuarios
                </h1>

                <p class="mt-1 text-sm text-slate-500">
                    Consulta y administra las cuentas registradas en GEMAS.
                </p>
            </div>

            <a href="{{ route('usuario.create') }}"
                class="inline-flex items-center justify-center gap-2 rounded-xl
                    bg-[#40899A] px-5 py-3 text-sm font-semibold text-white
                    shadow-sm transition hover:bg-[#347787]">

                <svg class="h-5 w-5" fill="none" stroke="currentColor"
                    viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        stroke-width="2" d="M12 4v16m8-8H4"/>
                </svg>

                Registrar Usuario
            </a>
        </div>


        {{-- Mensajes del sistema --}}
        @if(session('success'))
            <div class="rounded-lg border border-green-200
                        bg-green-50 px-4 py-3 text-sm text-green-700">
                {{ session('success') }}
            </div>
        @endif

        @if(session('update'))
            <div class="rounded-lg border border-blue-200
                        bg-blue-50 px-4 py-3 text-sm text-blue-700">
                {{ session('update') }}
            </div>
        @endif

        @if(session('destroy'))
            <div class="rounded-lg border border-red-200
                        bg-red-50 px-4 py-3 text-sm text-red-700">
                {{ session('destroy') }}
            </div>
        @endif

        <x-filtros-tabla
            buscador-id="buscarUsuario"
            placeholder="Nombre, documento, teléfono o correo..."
            contador-id="contadorUsuarios"
            limpiar-id="limpiarFiltrosUsuarios"
            :contador-total="$usuarios->total()"
            :filtros="[
                [
                    'id' => 'filtroRol',
                    'name' => 'rol',
                    'label' => 'Rol del usuario',
                    'todos' => 'Todos los roles',
                    'opciones' => [
                        'administrador' => 'Administrador',
                        'usuario' => 'Usuario',
                        'veterinario' => 'Veterinario',
                    ],
                ],
            ]"
        />


        {{-- Tabla de usuarios --}}
        <div class="bg-white rounded-xl border border-slate-200
                    shadow-sm overflow-hidden">

            {{-- Encabezado de la tabla --}}
            <div class="border-b border-slate-200 px-6 py-5">
                <h2 class="text-lg font-semibold text-slate-800">
                    Usuarios registrados
                </h2>

                <p class="mt-1 text-sm text-slate-500">
                    Información general de los usuarios registrados en el sistema.
                </p>
            </div>

            <div class="w-full min-w-0 overflow-x-auto">

                @php
                    $hayFiltrosAplicados = collect(request()->query())
                        ->except('page')
                        ->filter(fn ($valor) => filled($valor))
                        ->isNotEmpty();
                @endphp

                <table class="w-full text-sm text-left">

                    <thead class="bg-slate-50 text-slate-500">

                        <tr>

                            @if(auth()->user()->hasRole('administrador'))
                                <th class="px-6 py-3 font-medium">
                                    #
                                </th>
                            @endif

                            <th class="px-6 py-3 font-medium">
                                Usuario
                            </th>

                            <th class="px-6 py-3 font-medium">
                                Documento
                            </th>

                            <th class="px-5 py-4 text-left font-medium text-slate-600">
                                Rol
                            </th>

                            <th class="px-6 py-3 font-medium">
                                Teléfono
                            </th>

                            <th class="px-6 py-3 font-medium">
                                Correo electrónico
                            </th>

                            <th class="px-6 py-3 font-medium">
                                Dirección
                            </th>

                            <th class="px-6 py-3 font-medium text-center">
                                Acciones
                            </th>

                        </tr>

                    </thead>


                    <tbody class="divide-y divide-slate-100">

                        @forelse($usuarios as $usuario)

                            <tr class="hover:bg-slate-50 transition">

                                @if(auth()->user()->hasRole('administrador'))
                                    <td class="px-6 py-4 text-slate-500">
                                        {{ $usuario->id }}
                                    </td>
                                @endif

                                {{-- Usuario --}}
                                <td class="px-6 py-4">

                                    <div class="flex items-center gap-3">

                                        <div class="min-w-0">

                                            <p class="font-medium text-slate-700">
                                                {{ $usuario->nombre }}
                                                {{ $usuario->apellido }}
                                            </p>

                                        </div>

                                    </div>

                                </td>


                                {{-- Documento --}}
                                <td class="px-6 py-4 text-slate-700">
                                    {{ $usuario->documentoIdentidad }}
                                </td>

                                {{-- Rol --}}
                                <td class="px-5 py-4">
                                    <div class="flex flex-wrap gap-2">
                                        @forelse($usuario->roles as $rol)

                                            @if($rol->name === 'administrador')
                                                <span class="inline-flex items-center rounded-full
                                                            bg-purple-50 px-3 py-1 text-xs
                                                            font-semibold text-purple-700">
                                                    Administrador
                                                </span>

                                            @elseif($rol->name === 'veterinario')
                                                <span class="inline-flex items-center rounded-full
                                                            bg-blue-50 px-3 py-1 text-xs
                                                            font-semibold text-blue-700">
                                                    Veterinario
                                                </span>

                                            @elseif($rol->name === 'usuario')
                                                <span class="inline-flex items-center rounded-full
                                                            bg-[#EAF4F5] px-3 py-1 text-xs
                                                            font-semibold text-[#40899A]">
                                                    Usuario
                                                </span>

                                            @else
                                                <span class="inline-flex items-center rounded-full
                                                            bg-slate-100 px-3 py-1 text-xs
                                                            font-semibold text-slate-600">
                                                    {{ ucfirst($rol->name) }}
                                                </span>
                                            @endif

                                        @empty
                                            <span class="text-xs text-slate-400">
                                                Sin rol asignado
                                            </span>
                                        @endforelse
                                    </div>
                                </td>

                                {{-- Teléfono --}}
                                <td class="px-6 py-4 text-slate-700">
                                    {{ $usuario->telefono ?: 'No registrado' }}
                                </td>


                                {{-- Correo --}}
                                <td class="px-6 py-4 text-slate-700">
                                    <span class="break-all">
                                        {{ $usuario->email ?: 'No registrado' }}
                                    </span>
                                </td>


                                {{-- Dirección --}}
                                <td class="px-6 py-4 text-slate-700">
                                    <span class="block max-w-xs truncate"
                                        title="{{ $usuario->direccion }}">
                                        {{ $usuario->direccion ?: 'No registrada' }}
                                    </span>
                                </td>


                                {{-- Acciones --}}
                                <td class="px-6 py-4">

                                    <div class="flex justify-center">

                                        <a href="{{ route('usuario.edit', $usuario->id) }}"
                                            class="inline-flex items-center justify-center gap-1.5 rounded-lg bg-[#EAF4F5] px-3 py-2 text-xs font-semibold text-[#40899A] transition hover:bg-[#d5ebed]"
                                            title="Editar mascota">

                                            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                                                    d="m16.862 4.487 2.651 2.651M4 20l4.5-.9L19.2 8.4a1.875 1.875 0 0 0-2.65-2.65L5.85 16.45 4 20Z"/>
                                            </svg>

                                            Editar
                                        </a>

                                    </div>

                                </td>

                            </tr>

                        @empty

                            @if ($hayFiltrosAplicados)
                                {{-- Sin resultados de búsqueda --}}
                                <tr>
                                    <td colspan="7" class="px-6 py-10 text-center">
                                        <h3 class="text-lg font-semibold text-slate-700">
                                            No se encontraron resultados
                                        </h3>

                                        <p class="mt-1 text-sm text-slate-500">
                                            No hay usuarios que coincidan con los filtros aplicados.
                                        </p>
                                    </td>
                                </tr>

                            @else

                                {{-- Sin usuarios --}}
                                <tr>
                                    <td colspan="7" class="px-6 py-10 text-center">

                                        <div class="mx-auto w-16 h-16 rounded-full bg-[#EAF4F5]
                                                    flex items-center justify-center text-[#40899A]">

                                            @include('layouts.partials.icons', [
                                                'icon' => 'usuario'
                                            ])

                                        </div>

                                        <h3 class="mt-4 text-lg font-semibold text-slate-800">
                                            No hay usuarios registrados
                                        </h3>

                                        <p class="mt-2 text-sm text-slate-500">
                                            Cuando registres un usuario, aparecerá aquí.
                                        </p>

                                        <a href="{{ route('usuario.create') }}"
                                            class="inline-flex items-center gap-2 mt-5 rounded-lg
                                                bg-primary-600 px-4 py-2.5 text-sm font-semibold
                                                text-white hover:bg-primary-700 transition">

                                            Registrar primer usuario

                                        </a>

                                    </td>
                                </tr>

                            @endif

                        @endforelse

                    </tbody>

                </table>

            </div>

        </div>

        {{--Paginación--}}
        @if($usuarios->hasPages())
            <div class="border-t border-slate-200 bg-white px-4 py-4 sm:px-6">

                <div class="flex flex-col gap-3 sm:flex-row
                            sm:items-center sm:justify-between">

                    <p class="text-sm text-slate-500">
                        Mostrando
                        <span class="font-semibold text-slate-700">
                            {{ $usuarios->firstItem() ?? 0 }}
                        </span>
                        a
                        <span class="font-semibold text-slate-700">
                            {{ $usuarios->lastItem() ?? 0 }}
                        </span>
                        de
                        <span class="font-semibold text-slate-700">
                            {{ $usuarios->total() }}
                        </span>
                        usuarios
                    </p>

                    <div>
                        {{ $usuarios->onEachSide(1)->links('vendor.pagination.gemas') }}
                    </div>

                </div>
            </div>
        @endif

    </div>

@endsection