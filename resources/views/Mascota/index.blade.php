@extends('layouts.app')

@section('title')
    Mascotas - Gemas
@endsection

@section('content')

    <div class="w-full max-w-7xl mx-auto space-y-6">

        {{-- Encabezado --}}
        <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <h2 class="text-2xl font-bold text-slate-800">
                    Mascotas
                </h2>

                <p class="mt-1 text-sm text-slate-500">
                    Consulta la información de las mascotas registradas en GEMAS.
                </p>
            </div>

            <a href="{{ route('mascota.create') }}"
                class="inline-flex items-center justify-center gap-2 rounded-xl
                    bg-[#40899A] px-5 py-3 text-sm font-semibold text-white
                    shadow-sm transition hover:bg-[#347787]">

                <svg class="h-5 w-5" fill="none" stroke="currentColor"
                    viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        stroke-width="2" d="M12 4v16m8-8H4"/>
                </svg>

                Registrar Mascota
            </a>
        </div>

        {{-- Filtros --}}
        <x-filtros-tabla
            buscador-id="buscarMascota"
            placeholder="Nombre, raza, especie o propietario..."
            contador-id="contadorMascotas"
            limpiar-id="limpiarFiltrosMascotas"
            :contador-total="$mascotas->total()"
            :filtros="[
                [
                    'id' => 'filtroEspecie',
                    'name' => 'especie',
                    'label' => 'Especie',
                    'todos' => 'Todas las especies',
                    'opciones' => $especies->mapWithKeys(fn ($especie) => [
                        $especie => $especie
                    ])->toArray(),
                ],
                [
                    'id' => 'filtroSexo',
                    'name' => 'sexo',
                    'label' => 'Sexo',
                    'todos' => 'Todos los sexos',
                    'opciones' => [
                        'Macho' => 'Macho',
                        'Hembra' => 'Hembra',
                    ],
                ],
            ]"
        />

        {{-- Mensajes del sistema --}}
        @if(session('success'))
            <div class="rounded-lg border border-green-200 bg-green-50 px-4 py-3 text-sm text-green-700">
                {{ session('success') }}
            </div>
        @endif

        @if(session('update'))
            <div class="rounded-lg border border-blue-200 bg-blue-50 px-4 py-3 text-sm text-blue-700">
                {{ session('update') }}
            </div>
        @endif

        @if(session('destroy'))
            <div class="rounded-lg border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-700">
                {{ session('destroy') }}
            </div>
        @endif

        {{-- Tabla de mascotas --}}
        <div class="overflow-hidden rounded-xl border border-slate-200 bg-white shadow-sm">

            {{-- Encabezado de la tabla --}}
            <div class="border-b border-slate-200 px-6 py-5">
                <h2 class="text-lg font-semibold text-slate-800">
                    Mascotas registradas
                </h2>

                <p class="mt-1 text-sm text-slate-500">
                    Listado de las mascotas y sus datos principales.
                </p>
            </div>

            <div class="w-full min-w-0 overflow-x-auto">

                @php
                    $hayFiltrosAplicados = collect(request()->query())
                        ->except('page')
                        ->filter(fn ($valor) => filled($valor))
                        ->isNotEmpty();
                @endphp

                <table class="w-full text-left text-sm">

                    <thead class="bg-slate-50 text-slate-500">
                        <tr>
                            @if(auth()->user()->hasRole('administrador'))
                                <th class="whitespace-nowrap px-6 py-3 font-medium">
                                    #
                                </th>
                            @endif

                            <th class="whitespace-nowrap px-5 py-3 font-medium">
                                Mascota
                            </th>

                            <th class="whitespace-nowrap px-5 py-3 font-medium">
                                Raza
                            </th>

                            <th class="whitespace-nowrap px-5 py-3 font-medium">
                                Sexo
                            </th>

                            <th class="whitespace-nowrap px-5 py-3 font-medium">
                                Cuidador
                            </th>

                            <th class="whitespace-nowrap px-5 py-3 font-medium">
                                Peso
                            </th>

                            <th class="whitespace-nowrap px-5 py-3 text-center font-medium">
                                Acciones
                            </th>
                        </tr>
                    </thead>

                    <tbody class="divide-y divide-slate-100">

                        @forelse($mascotas as $mascota)

                            <tr class="transition hover:bg-slate-50">

                                @if(auth()->user()->hasRole('administrador'))
                                    <td class="whitespace-nowrap px-6 py-4 text-slate-500">
                                        {{ $mascota->id }}
                                    </td>
                                @endif

                                {{-- Mascota --}}
                                <td class="px-5 py-4">
                                    <div class="flex min-w-48 items-center gap-3">

                                        <div class="flex h-12 w-12 shrink-0 items-center justify-center overflow-hidden rounded-full border border-slate-200 bg-slate-50">

                                            @if($mascota->imagen && file_exists(public_path('storage/' . $mascota->imagen)))
                                                <img
                                                    src="{{ asset('storage/' . $mascota->imagen) }}"
                                                    alt="Fotografía de {{ $mascota->nombre }}"
                                                    class="h-full w-full object-cover"
                                                >
                                            @else
                                                <div class="text-[#40899A] items-center justify-center">
                                                    @include('layouts.partials.icons', ['icon' => 'mascota'])
                                                </div>
                                            @endif

                                        </div>

                                        <div class="min-w-0">
                                            <p class="truncate font-semibold text-slate-800">
                                                {{ $mascota->nombre }}
                                            </p>

                                            <p class="mt-0.5 text-xs text-slate-500">
                                                {{ $mascota->especie }}
                                            </p>
                                        </div>

                                    </div>
                                </td>

                                {{-- Raza --}}
                                <td class="px-5 py-4 text-slate-700">
                                    {{ $mascota->raza ?: 'No especificada' }}
                                </td>

                                {{-- Sexo --}}
                                <td class="px-5 py-4">
                                    @if($mascota->sexo === 'Macho')
                                        <span class="inline-flex items-center rounded-full bg-blue-50 px-2.5 py-1 text-xs font-medium text-blue-700">
                                            Macho
                                        </span>
                                    @else
                                        <span class="inline-flex items-center rounded-full bg-pink-50 px-2.5 py-1 text-xs font-medium text-pink-700">
                                            Hembra
                                        </span>
                                    @endif
                                </td>

                                {{-- Propietario --}}
                                <td class="whitespace-nowrap px-5 py-4 text-slate-700">
                                    {{ $mascota->Usuario->nombre ?? 'Sin propietario' }}
                                    @if($mascota->Usuario?->apellido)
                                        {{ $mascota->Usuario->apellido }}
                                    @endif
                                </td>

                                {{-- Peso --}}
                                <td class="whitespace-nowrap px-5 py-4 text-slate-700">
                                    {{ $mascota->peso !== null ? number_format($mascota->peso, 2) . ' kg' : 'No registrado' }}
                                </td>

                                {{-- Acciones --}}
                                <td class="px-5 py-4">
                                    <div class="flex justify-center">

                                        <a href="{{ route('mascota.edit', $mascota->id) }}"
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
                                    <td colspan="{{ auth()->user()->hasRole('administrador') ? 7 : 6 }}"
                                        class="px-6 py-12 text-center">

                                        <h3 class="text-base font-semibold text-slate-700">
                                            No se encontraron resultados
                                        </h3>

                                        <p class="mt-1 text-sm text-slate-500">
                                            No hay mascotas que coincidan con los filtros aplicados.
                                        </p>

                                    </td>
                                </tr>

                            @else

                                {{-- Sin mascotas --}}
                                <tr>
                                    <td colspan="{{ auth()->user()->hasRole('administrador') ? 7 : 6 }}"
                                        class="px-6 py-12 text-center">

                                        <div class="mx-auto flex h-14 w-14 items-center justify-center
                                                    rounded-full bg-[#EAF4F5] text-[#40899A]">

                                            @include('layouts.partials.icons', ['icon' => 'mascota'])

                                        </div>

                                        <h3 class="mt-4 text-base font-semibold text-slate-800">
                                            No hay mascotas registradas
                                        </h3>

                                        <p class="mt-1 text-sm text-slate-500">
                                            Cuando registres una mascota, aparecerá aquí.
                                        </p>

                                        <a href="{{ route('mascota.create') }}"
                                            class="inline-flex items-center gap-2 mt-4
                                                rounded-lg bg-primary-600 px-4 py-2.5
                                                text-sm font-semibold text-white
                                                hover:bg-primary-700 transition">

                                            Registrar primera mascota

                                        </a>

                                    </td>
                                </tr>

                            @endif

                        @endforelse

                    </tbody>
                </table>
            </div>

            {{-- Paginación --}}
            @if($mascotas->hasPages())
                <div class="border-t border-slate-200 bg-white px-4 py-4 sm:px-6">

                    <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">

                        <p class="text-sm text-slate-500">
                            Mostrando
                            <span class="font-semibold text-slate-700">
                                {{ $mascotas->firstItem() ?? 0 }}
                            </span>
                            a
                            <span class="font-semibold text-slate-700">
                                {{ $mascotas->lastItem() ?? 0 }}
                            </span>
                            de
                            <span class="font-semibold text-slate-700">
                                {{ $mascotas->total() }}
                            </span>
                            mascotas
                        </p>

                        <div>
                            {{ $mascotas->onEachSide(1)->links('vendor.pagination.gemas') }}
                        </div>

                    </div>

                </div>
            @endif

        </div>

    </div>

@endsection


