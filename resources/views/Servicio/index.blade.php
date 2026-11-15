@extends('layouts.app')
    
@section('title')
    Servicio - Gemas
@endsection

@section('content')

    <div class="w-full max-w-7xl mx-auto space-y-6">

        @php
            $esAdministrador = auth()->user()->hasRole('administrador');
        @endphp

        {{-- Encabezado --}}
        <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <h1 class="text-2xl font-bold text-slate-800">
                    Servicios
                </h1>

                <p class="mt-1 text-sm text-slate-500">
                    Consulta la información de los servicios veterinarios disponibles.
                </p>
            </div>

            @if($esAdministrador)
                <a href="{{ route('servicio.create') }}"
                    class="inline-flex items-center justify-center gap-2 rounded-xl
                        bg-[#40899A] px-5 py-3 text-sm font-semibold text-white
                        shadow-sm transition hover:bg-[#347787]">

                    <svg class="h-5 w-5" fill="none" stroke="currentColor"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            stroke-width="2" d="M12 4v16m8-8H4"/>
                    </svg>

                    Registrar Servicio
                </a>
            @endif
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

        {{-- Filtros --}}
        <x-filtros-tabla
            buscador-id="buscarServicio"
            placeholder="Buscar por nombre o descripción..."
            contador-id="contadorServicios"
            limpiar-id="limpiarFiltrosServicios"
            :contador-total="$servicios->total()"
            :filtros="[
                [
                    'id' => 'filtroDuracion',
                    'name' => 'tiempo',
                    'label' => 'Duración',
                    'todos' => 'Todas las duraciones',
                    'opciones' => [
                        '30' => 'Hasta 30 minutos',
                        '60' => 'De 31 a 60 minutos',
                        '120' => 'De 61 a 120 minutos',
                        'mas120' => 'Más de 120 minutos',
                    ],
                ],
            ]"
        />

        {{-- Tabla de servicios --}}
        <div class="bg-white rounded-xl border border-slate-200
                    shadow-sm overflow-hidden">

            {{-- Encabezado de la tabla --}}
            <div class="border-b border-slate-200 px-6 py-5">
                <h2 class="text-lg font-semibold text-slate-800">
                    Servicios registrados
                </h2>

                <p class="mt-1 text-sm text-slate-500">
                    Listado de los servicios y sus características.
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

                            @if($esAdministrador)
                                <th class="px-6 py-3 font-medium">
                                    #
                                </th>
                            @endif

                            <th class="px-6 py-3 font-medium">
                                Servicio
                            </th>

                            <th class="px-6 py-3 font-medium">
                                Descripción
                            </th>

                            <th class="px-6 py-3 font-medium text-center">
                                Duración
                            </th>

                            @if($esAdministrador)
                                <th class="px-6 py-3 font-medium text-center">
                                    Acciones
                                </th>
                            @endif

                        </tr>
                    </thead>

                    <tbody class="divide-y divide-slate-100">

                        @forelse($servicios as $servicio)

                            <tr class="hover:bg-slate-50 transition">

                                {{-- ID --}}
                                @if($esAdministrador)
                                    <td class="px-6 py-4 text-slate-500">
                                        {{ $servicio->id }}
                                    </td>
                                @endif

                                {{-- Nombre --}}
                                <td class="px-6 py-4">
                                    <p class="font-medium text-slate-700">
                                        {{ $servicio->nombre }}
                                    </p>
                                </td>

                                {{-- Descripción --}}
                                <td class="px-6 py-4 text-slate-600">
                                    <span class="block max-w-md">
                                        {{ $servicio->descripcion ?: 'Sin descripción' }}
                                    </span>
                                </td>

                                {{-- Duración --}}
                                <td class="px-6 py-4 text-center">
                                    <span class="inline-flex items-center gap-1.5 rounded-full
                                                bg-[#EAF4F5] px-3 py-1.5 text-xs
                                                font-semibold text-[#40899A]">

                                        <svg class="h-4 w-4" fill="none"
                                            stroke="currentColor" viewBox="0 0 24 24">
                                            <circle cx="12" cy="12" r="9"
                                                stroke-width="2"/>
                                            <path stroke-linecap="round"
                                                stroke-linejoin="round" stroke-width="2"
                                                d="M12 7v5l3 2"/>
                                        </svg>

                                        {{ $servicio->duracionMinutos }} min
                                    </span>
                                </td>

                                {{-- Acciones --}}
                                @if($esAdministrador)
                                    <td class="px-6 py-4">

                                        <div class="flex justify-center gap-2">

                                            {{-- Editar --}}
                                            <a href="{{ route('servicio.edit', $servicio->id) }}"
                                                class="inline-flex items-center justify-center gap-1.5
                                                    rounded-lg bg-[#EAF4F5] px-3 py-2
                                                    text-xs font-semibold text-[#40899A]
                                                    transition hover:bg-[#d5ebed]"
                                                title="Editar servicio">

                                                <svg class="h-4 w-4" fill="none"
                                                    stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round"
                                                        stroke-linejoin="round" stroke-width="1.8"
                                                        d="m16.862 4.487 2.651 2.651M4 20l4.5-.9L19.2 8.4a1.875 1.875 0 0 0-2.65-2.65L5.85 16.45 4 20Z"/>
                                                </svg>

                                                Editar
                                            </a>

                                            {{-- Eliminar --}}
                                            <button type="button"
                                                onclick="document.getElementById('modalEliminarServicio-{{ $servicio->id }}').classList.remove('hidden')"
                                                class="inline-flex items-center justify-center gap-1.5
                                                    rounded-lg bg-red-50 px-3 py-2
                                                    text-xs font-semibold text-red-600
                                                    transition hover:bg-red-100"
                                                title="Eliminar servicio">

                                                <svg class="h-4 w-4" fill="none"
                                                    stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round"
                                                        stroke-linejoin="round" stroke-width="1.8"
                                                        d="M6 7h12m-10 0V5h8v2m-9 0 1 13h8l1-13M10 11v5m4-5v5"/>
                                                </svg>

                                                Eliminar
                                            </button>

                                        </div>

                                        {{-- Modal eliminar servicio --}}
                                        <div id="modalEliminarServicio-{{ $servicio->id }}"
                                            class="hidden fixed inset-0 z-50 flex items-center justify-center
                                                bg-black/50 p-4">

                                            <div class="w-full max-w-md rounded-2xl bg-white p-6 shadow-xl">

                                                {{-- Icono --}}
                                                <div class="mx-auto flex h-14 w-14 items-center justify-center
                                                    rounded-full bg-red-100 text-red-600">

                                                    <svg class="h-10 w-10" fill="none" stroke="currentColor"
                                                        viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="1.3"
                                                            d="M6 7h12m-10 0V5h8v2m-9 2 1 11h8l1-11M10 11v5m4-5v5" />
                                                    </svg>
                                                </div>

                                                {{-- Texto --}}
                                                <div class="mt-4 text-center">
                                                    <h3 class="text-lg font-semibold text-slate-800">
                                                        ¿Eliminar servicio?
                                                    </h3>

                                                    <p class="mt-2 text-sm text-slate-500">
                                                        ¿Estás seguro de que deseas eliminar el servicio
                                                        <span class="font-semibold text-slate-700">
                                                            {{ $servicio->nombre }}
                                                        </span>?
                                                        Esta acción no se puede deshacer.
                                                    </p>
                                                </div>

                                                {{-- Botones --}}
                                                <div class="mt-6 flex justify-center gap-3">

                                                    <button type="button"
                                                        onclick="document.getElementById('modalEliminarServicio-{{ $servicio->id }}').classList.add('hidden')"
                                                        class="rounded-lg border border-slate-300 px-4 py-2
                                                            text-sm font-medium text-slate-600
                                                            transition hover:bg-slate-50">
                                                        Cancelar
                                                    </button>

                                                    <form action="{{ route('servicio.destroy', $servicio->id) }}"
                                                        method="POST">

                                                        @csrf
                                                        @method('DELETE')

                                                        <button type="submit"
                                                            class="rounded-lg bg-red-600 px-4 py-2
                                                                text-sm font-semibold text-white
                                                                transition hover:bg-red-700">
                                                            Sí, eliminar
                                                        </button>
                                                    </form>

                                                </div>
                                            </div>
                                        </div>

                                    </td>
                                @endif

                            </tr>

                        @empty

                            @if ($hayFiltrosAplicados)

                                {{-- Sin resultados de búsqueda --}}
                                <tr>
                                    <td colspan="{{ $esAdministrador ? 5 : 3 }}"
                                        class="px-6 py-10 text-center">

                                        <h3 class="text-lg font-semibold text-slate-700">
                                            No se encontraron resultados
                                        </h3>

                                        <p class="mt-1 text-sm text-slate-500">
                                            No hay servicios que coincidan con los filtros aplicados.
                                        </p>

                                    </td>
                                </tr>

                            @else

                                {{-- Sin servicios --}}
                                <tr>
                                    <td colspan="{{ $esAdministrador ? 5 : 3 }}"
                                        class="px-6 py-10 text-center">

                                        <div class="mx-auto flex h-16 w-16 items-center justify-center
                                                    rounded-full bg-[#EAF4F5] text-[#40899A]">

                                            @include('layouts.partials.icons', [
                                                'icon' => 'servicio'
                                            ])

                                        </div>

                                        <h3 class="mt-4 text-lg font-semibold text-slate-800">
                                            No hay servicios registrados
                                        </h3>

                                        <p class="mt-2 text-sm text-slate-500">
                                            Cuando registres un servicio, aparecerá aquí.
                                        </p>

                                        @if($esAdministrador)

                                            <a href="{{ route('servicio.create') }}"
                                                class="inline-flex items-center gap-2 mt-5 rounded-lg
                                                    bg-[#40899A] px-4 py-2.5 text-sm font-semibold
                                                    text-white transition hover:bg-[#347787]">

                                                Registrar primer servicio

                                            </a>

                                        @endif

                                    </td>
                                </tr>

                            @endif

                        @endforelse

                    </tbody>
                </table>

            </div>
        </div>

        {{-- Paginación --}}
        @if($servicios->hasPages())
            <div class="border-t border-slate-200 bg-white px-4 py-4 sm:px-6">

                <div class="flex flex-col gap-3 sm:flex-row
                            sm:items-center sm:justify-between">

                    <p class="text-sm text-slate-500">
                        Mostrando
                        <span class="font-semibold text-slate-700">
                            {{ $servicios->firstItem() ?? 0 }}
                        </span>
                        a
                        <span class="font-semibold text-slate-700">
                            {{ $servicios->lastItem() ?? 0 }}
                        </span>
                        de
                        <span class="font-semibold text-slate-700">
                            {{ $servicios->total() }}
                        </span>
                        servicios
                    </p>

                    <div>
                        {{ $servicios->onEachSide(1)->withQueryString()->links('vendor.pagination.gemas') }}
                    </div>

                </div>
            </div>
        @endif

    </div>

@endsection

