@extends('layouts.app')

@section('title')
    Horarios - Gemas
@endsection

@section('content')

    <div class="w-full max-w-7xl mx-auto space-y-6">

        {{-- Encabezado --}}
        <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <h1 class="text-2xl font-bold text-slate-800">
                    Horarios
                </h1>

                <p class="mt-1 text-sm text-slate-500">
                    Consulta los horarios y las jornadas de atención veterinaria.
                </p>
            </div>

            @if(auth()->user()->tieneRolActivo('administrador') || auth()->user()->tieneRolActivo('veterinario'))

                <a href="{{ route('horario.create') }}"
                    class="inline-flex items-center justify-center gap-2 rounded-xl
                        bg-[#40899A] px-5 py-3 text-sm font-semibold text-white
                        shadow-sm transition hover:bg-[#347787]">

                    <svg class="h-5 w-5" fill="none" stroke="currentColor"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            stroke-width="2" d="M12 4v16m8-8H4"/>
                    </svg>

                    Registrar horario
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
            buscador-id="buscarHorario"
            placeholder="Buscar por día o nombre del veterinario..."
            contador-id="contadorHorarios"
            limpiar-id="limpiarFiltrosHorarios"
            :contador-total="$horarios->total()"
            :filtros="[
                [
                    'id' => 'filtroDia',
                    'name' => 'diaSemana',
                    'label' => 'Día de la semana',
                    'todos' => 'Todos los días',
                    'opciones' => [
                        'Lunes' => 'Lunes',
                        'Martes' => 'Martes',
                        'Miércoles' => 'Miércoles',
                        'Jueves' => 'Jueves',
                        'Viernes' => 'Viernes',
                        'Sábado' => 'Sábado',
                        'Domingo' => 'Domingo',
                    ],
                ],
                [
                    'id' => 'filtroVeterinario',
                    'name' => 'idVeterinario',
                    'label' => 'Veterinario',
                    'todos' => 'Todos los veterinarios',
                    'opciones' => $veterinarios->pluck('nombre', 'id')->toArray(),
                ],
            ]"
        />


        {{-- Tabla de horarios --}}
        <div class="overflow-hidden rounded-xl border border-slate-200 bg-white shadow-sm">

            {{-- Encabezado de la tabla --}}
            <div class="border-b border-slate-200 px-6 py-5">
                <h2 class="text-lg font-semibold text-slate-800">
                    Horarios registrados
                </h2>

                <p class="mt-1 text-sm text-slate-500">
                    Listado de las jornadas y los horarios de atención veterinaria.
                </p>
            </div>

            <div class="w-full min-w-0 overflow-x-auto">

                @php
                    $puedeGestionarHorarios = auth()->user()->hasAnyRole(['administrador', 'veterinario']);

                    $hayFiltrosAplicados = collect(request()->query())
                            ->except('page')
                            ->filter(fn ($valor) => filled($valor))
                            ->isNotEmpty();
                @endphp

                <table class="w-full text-sm text-left">

                    <thead class="bg-slate-50 text-slate-500">
                        <tr>

                            @if(auth()->user()->hasRole('administrador'))
                                <th class="whitespace-nowrap px-6 py-3 font-medium">
                                    #
                                </th>
                            @endif

                            <th class="px-6 py-3 font-medium">
                                Día de la semana
                            </th>

                            <th class="px-6 py-3 font-medium">
                                Inicio de jornada
                            </th>

                            <th class="px-6 py-3 font-medium">
                                Fin de jornada
                            </th>

                            <th class="px-6 py-3 font-medium">
                                Horario de almuerzo
                            </th>

                            <th class="px-6 py-3 font-medium">
                                Veterinario
                            </th>

                            @if($puedeGestionarHorarios)
                                <th class="px-6 py-3 text-center font-medium">
                                    Acciones
                                </th>
                            @endif

                        </tr>
                    </thead>

                    <tbody class="divide-y divide-slate-100">

                        @forelse($horarios as $horario)

                            <tr class="transition hover:bg-slate-50">

                                 @if(auth()->user()->hasRole('administrador'))
                                    <td class="px-6 py-4 text-slate-500">
                                        {{ $horario->id }}
                                    </td>
                                @endif

                                {{-- Día --}}
                                <td class="px-6 py-4">
                                    <span class="inline-flex items-center rounded-full
                                                bg-[#EAF4F5] px-3 py-1 text-xs
                                                font-semibold text-[#40899A]">
                                        {{ $horario->diaSemana }}
                                    </span>
                                </td>

                                {{-- Inicio de jornada --}}
                                <td class="px-6 py-4 whitespace-nowrap text-slate-700">
                                    {{ \Carbon\Carbon::parse($horario->horaInicio)->format('g:i A') }}
                                </td>

                                {{-- Fin de jornada --}}
                                <td class="px-6 py-4 whitespace-nowrap text-slate-700">
                                    {{ \Carbon\Carbon::parse($horario->horaFin)->format('g:i A') }}
                                </td>

                                {{-- Almuerzo --}}
                                <td class="px-6 py-4 whitespace-nowrap">

                                    @if($horario->horaAlmuerzoInicio && $horario->horaAlmuerzoFin)

                                        <span class="text-slate-700">
                                            {{ \Carbon\Carbon::parse($horario->horaAlmuerzoInicio)->format('g:i A') }}
                                            -
                                            {{ \Carbon\Carbon::parse($horario->horaAlmuerzoFin)->format('g:i A') }}
                                        </span>

                                    @else

                                        <span class="text-xs font-medium text-slate-400">
                                            No definido
                                        </span>

                                    @endif

                                </td>

                                {{-- Veterinario --}}
                                <td class="px-6 py-4">

                                    <div class="flex items-center gap-3">

                                        <span class="font-medium text-slate-700">
                                            {{ optional($horario->Veterinario)->nombre ?? 'No asignado' }}
                                        </span>

                                    </div>

                                </td>

                                {{-- Acciones --}}
                                <td class="px-6 py-4">

                                    @if($puedeGestionarHorarios)

                                        <div class="flex items-center justify-center gap-2">

                                            {{-- Editar --}}
                                            <a href="{{ route('horario.edit', $horario->id) }}"
                                                class="inline-flex items-center justify-center gap-1.5
                                                    rounded-lg bg-[#EAF4F5] px-3 py-2
                                                    text-xs font-semibold text-[#40899A]
                                                    transition hover:bg-[#d5ebed]"
                                                title="Editar horario">

                                                <svg class="h-4 w-4" fill="none"
                                                    stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round"
                                                        stroke-linejoin="round"
                                                        stroke-width="1.8"
                                                        d="m16.862 4.487 2.651 2.651M4 20l4.5-.9L19.2 8.4a1.875 1.875 0 0 0-2.65-2.65L5.85 16.45 4 20Z"/>
                                                </svg>

                                                Editar
                                            </a>

                                            {{-- Eliminar --}}
                                            <button type="button"
                                                onclick="document.getElementById('modalEliminarHorario-{{ $horario->id }}').classList.remove('hidden')"
                                                class="inline-flex items-center justify-center gap-1.5
                                                    rounded-lg bg-red-50 px-3 py-2
                                                    text-xs font-semibold text-red-600
                                                    transition hover:bg-red-100"
                                                title="Eliminar horario">

                                                <svg class="h-4 w-4" fill="none"
                                                    stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round"
                                                        stroke-linejoin="round"
                                                        stroke-width="1.8"
                                                        d="M6 7h12m-10 0 .7 12h6.6L16 7M9 7V4h6v3m-5 4v5m4-5v5"/>
                                                </svg>

                                                Eliminar
                                            </button>

                                        </div>

                                        {{-- Modal eliminar horario --}}
                                        <div id="modalEliminarHorario-{{ $horario->id }}"
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
                                                        ¿Eliminar horario?
                                                    </h3>

                                                    <p class="mt-2 text-sm text-slate-500">
                                                        ¿Estás seguro de que deseas eliminar este horario?
                                                        Esta acción no se puede deshacer.
                                                    </p>
                                                </div>

                                                {{-- Botones --}}
                                                <div class="mt-6 flex justify-center gap-3">

                                                    <button type="button"
                                                        onclick="document.getElementById('modalEliminarHorario-{{ $horario->id }}').classList.add('hidden')"
                                                        class="rounded-lg border border-slate-300 px-4 py-2
                                                            text-sm font-medium text-slate-600
                                                            transition hover:bg-slate-50">
                                                        Cancelar
                                                    </button>

                                                    <form action="{{ route('horario.destroy', $horario->id) }}"
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

                                    @endif

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
                                            No hay horarios que coincidan con los filtros aplicados.
                                        </p>

                                    </td>
                                </tr>

                            @else

                                {{-- Sin horarios --}}
                                <tr>
                                    <td colspan="7" class="px-6 py-10 text-center">

                                        <div class="mx-auto flex h-16 w-16
                                                    items-center justify-center
                                                    rounded-full bg-[#EAF4F5]
                                                    text-[#40899A]">

                                            @include('layouts.partials.icons', [
                                                'icon' => 'horario'
                                            ])

                                        </div>

                                        <h3 class="mt-4 text-lg font-semibold text-slate-800">
                                            No hay horarios registrados
                                        </h3>

                                        <p class="mt-2 text-sm text-slate-500">
                                            Cuando registres un horario, aparecerá aquí.
                                        </p>

                                        @if(auth()->user()->can('crearhorario'))
                                            <a href="{{ route('horario.create') }}"
                                                class="mt-5 inline-flex items-center gap-2
                                                    rounded-lg bg-[#40899A] px-4 py-2.5
                                                    text-sm font-semibold text-white
                                                    transition hover:bg-[#347787]">

                                                Registrar primer horario

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
        @if($horarios->hasPages())

            <div class="border-t border-slate-200 bg-white px-4 py-4 sm:px-6">

                <div class="flex flex-col gap-3 sm:flex-row
                            sm:items-center sm:justify-between">

                    <p class="text-sm text-slate-500">
                        Mostrando
                        <span class="font-semibold text-slate-700">
                            {{ $horarios->firstItem() ?? 0 }}
                        </span>
                        a
                        <span class="font-semibold text-slate-700">
                            {{ $horarios->lastItem() ?? 0 }}
                        </span>
                        de
                        <span class="font-semibold text-slate-700">
                            {{ $horarios->total() }}
                        </span>
                        horarios
                    </p>

                    <div>
                        {{ $horarios->onEachSide(1)->links('vendor.pagination.gemas') }}
                    </div>

                </div>

            </div>

        @endif

    </div>

@endsection
