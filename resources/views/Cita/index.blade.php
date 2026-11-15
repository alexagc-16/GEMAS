@extends('layouts.app')

@section('title')
    Citas - Gemas
@endsection

@section('content')

    <div class="w-full max-w-7xl mx-auto space-y-6">

        {{-- Encabezado y filtros reutilizables --}}
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 mb-6">
                <div>
                    <h2 class="text-2xl font-bold text-slate-800">
                        Citas
                    </h2>

                    <p class="mt-1 text-sm text-slate-500">
                        Consulta la información de las citas veterinarias programadas.
                    </p>
                </div>

                @if(!auth()->user()->hasRole('veterinario'))
                
                    <a href="{{ route('cita.create') }}"class="inline-flex items-center justify-center gap-2 rounded-xl bg-[#40899A] px-5 py-3 text-sm font-semibold text-white shadow-sm transition hover:bg-[#347787]">

                        <svg class="h-5 w-5" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                stroke-width="2" d="M12 4v16m8-8H4"/>
                        </svg>

                        Agendar Cita
                    </a>
                    
                @endif
            </div>

            <x-filtros-tabla
                buscador-id="buscarCita"
                placeholder="Mascota, veterinario o servicio..."
                contador-id="contadorCitas"
                limpiar-id="limpiarFiltrosCitas"
                :contador-total="$citas->total()"
                :filtros="[
                    [
                        'id' => 'filtroEstado',
                        'name' => 'estado',
                        'label' => 'Estado de la cita',
                        'todos' => 'Todos los estados',
                        'opciones' => [
                            'Confirmada' => 'Confirmada',
                            'En atención' => 'En atención',
                            'Atendida' => 'Atendida',
                            'Cancelada' => 'Cancelada',
                            'No asistió' => 'No asistió',
                        ],
                    ],
                    [
                        'id' => 'filtroFecha',
                        'name' => 'fecha',
                        'label' => 'Fecha de la cita',
                        'tipo' => 'date',
                    ],
                ]"
            />

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

        @php
            $hayFiltrosAplicados = collect(request()->query())
                ->except('page')
                ->filter(fn ($valor) => filled($valor))
                ->isNotEmpty();
        @endphp

        {{-- Tabla de citas --}}
        <div id="vistaLista" class="bg-white rounded-xl border border-slate-200
                    shadow-sm overflow-hidden">

            {{-- Encabezado de la tabla --}}
            <div class="px-6 py-5 border-b border-slate-200">
                <h2 class="text-lg font-semibold text-slate-800">
                    Citas registradas
                </h2>

                <p class="mt-1 text-sm text-slate-500">
                    Listado de las citas y sus respectivos estados.
                </p>
            </div>

            {{-- Selector de vista --}}
            <div class="flex justify-center px-6 py-5">

                <div class="inline-flex items-center gap-1 rounded-full
                            border border-slate-200 bg-slate-100/80 p-1.5">

                    <button type="button" id="btnVistaLista"
                        class="inline-flex items-center justify-center gap-2
                            rounded-full bg-white px-5 py-2
                            text-sm font-semibold text-[#40899A]
                            shadow-sm ring-1 ring-slate-200/70
                            transition-all duration-200">

                        <svg class="h-4 w-4" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                stroke-width="1.8"
                                d="M8 6h13M8 12h13M8 18h13M3 6h.01M3 12h.01M3 18h.01"/>
                        </svg>

                        Lista
                    </button>

                    <button type="button" id="btnVistaCalendario"
                        class="inline-flex items-center justify-center gap-2
                            rounded-full px-5 py-2
                            text-sm font-medium text-slate-500
                            transition-all duration-200
                            hover:text-[#40899A]">

                        <svg class="h-4 w-4" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                stroke-width="1.8"
                                d="M8 2v4m8-4v4M3 10h18M5 4h14a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V6a2 2 0 0 1 2-2Z"/>
                        </svg>

                        Calendario
                    </button>

                </div>

            </div>

            <div class="w-full min-w-0 overflow-x-auto">

                <table class="w-full text-sm text-left">

                    <thead class="bg-slate-50 text-slate-500">
                        <tr>
                            @if(auth()->user()->hasRole('administrador'))
                                <th class="px-6 py-3 font-medium">
                                    #
                                </th>
                            @endif
                            <th class="px-5 py-3 font-medium whitespace-nowrap">Fecha</th>
                            <th class="px-5 py-3 font-medium whitespace-nowrap">Hora</th>
                            <th class="px-5 py-3 font-medium whitespace-nowrap">Motivo</th>
                            <th class="px-5 py-3 font-medium whitespace-nowrap">Estado</th>
                            <th class="px-5 py-3 font-medium whitespace-nowrap">Mascota</th>
                            <th class="px-5 py-3 font-medium whitespace-nowrap">Veterinario</th>
                            <th class="px-5 py-3 font-medium whitespace-nowrap">Servicio</th>
                            <th class="px-5 py-3 font-medium text-center whitespace-nowrap">Acciones</th>
                        </tr>
                    </thead>

                    <tbody class="divide-y divide-slate-100">

                        <tr id="sinResultadosCitas" class="hidden">
                            <td colspan="8" class="px-6 py-10 text-center">
                                <p class="text-sm font-medium text-slate-700">
                                    No se encontraron citas
                                </p>

                                <p class="mt-1 text-sm text-slate-500">
                                    Intenta cambiar los términos de búsqueda o los filtros aplicados.
                                </p>
                            </td>
                        </tr>

                        @forelse ($citas as $cita)

                            @php
                                $esVeterinarioAsignado = auth()->check()
                                    && auth()->user()->hasRole('veterinario')
                                    && auth()->user()->documentoIdentidad === ($cita->Veterinario->documentoIdentidad ?? null);
                            @endphp

                            <tr class="filaCita hover:bg-slate-50 transition"
                                data-mascota="{{ $cita->Mascota->nombre ?? '' }}"
                                data-veterinario="{{ $cita->Veterinario->nombre ?? '' }}"
                                data-servicio="{{ $cita->Servicio->nombre ?? '' }}"
                                data-estado="{{ $cita->estado }}"
                                data-fecha="{{ \Carbon\Carbon::parse($cita->fecha)->format('Y-m-d') }}">

                                @if(auth()->user()->hasRole('administrador'))
                                    <td class="px-6 py-4 text-slate-500">
                                        {{ $cita->id }}
                                    </td>
                                @endif

                                {{-- Fecha --}}
                                <td class="px-5 py-4 text-slate-700 whitespace-nowrap">
                                    {{ \Carbon\Carbon::parse($cita->fecha)->format('d/m/Y') }}
                                </td>

                                {{-- Hora --}}
                                <td class="px-5 py-4 text-slate-700 whitespace-nowrap">
                                    {{ \Carbon\Carbon::parse($cita->hora)->format('h:i A') }}
                                </td>

                                {{-- Motivo --}}
                                <td class="px-5 py-4 text-slate-600 min-w-48 max-w-xs">
                                    <p class="line-clamp-2">
                                        {{ $cita->motivo ?: 'Sin motivo registrado' }}
                                    </p>
                                </td>

                                {{-- Estado --}}
                                <td class="px-5 py-4 whitespace-nowrap">
                                    @if($cita->estado === 'Confirmada')
                                        <span class="inline-flex items-center gap-1.5
                                                    rounded-full bg-blue-50 px-2.5 py-1
                                                    text-xs font-medium text-blue-700">
                                            <span class="w-1.5 h-1.5 rounded-full bg-blue-500"></span>
                                            Confirmada
                                        </span>

                                    @elseif($cita->estado === 'En atención')
                                        <span class="inline-flex items-center gap-1.5
                                                    rounded-full bg-amber-50 px-2.5 py-1
                                                    text-xs font-medium text-amber-700">
                                            <span class="w-1.5 h-1.5 rounded-full bg-amber-500"></span>
                                            En atención
                                        </span>

                                    @elseif($cita->estado === 'Atendida')
                                        <span class="inline-flex items-center gap-1.5
                                                    rounded-full bg-green-50 px-2.5 py-1
                                                    text-xs font-medium text-green-700">
                                            <span class="w-1.5 h-1.5 rounded-full bg-green-500"></span>
                                            Atendida
                                        </span>

                                    @elseif($cita->estado === 'Cancelada')
                                        <span class="inline-flex items-center gap-1.5
                                                    rounded-full bg-red-50 px-2.5 py-1
                                                    text-xs font-medium text-red-700">
                                            <span class="w-1.5 h-1.5 rounded-full bg-red-500"></span>
                                            Cancelada
                                        </span>

                                    @elseif($cita->estado === 'No asistió')
                                        <span class="inline-flex items-center gap-1.5
                                                    rounded-full bg-slate-100 px-2.5 py-1
                                                    text-xs font-medium text-slate-600">
                                            <span class="w-1.5 h-1.5 rounded-full bg-slate-400"></span>
                                            No asistió
                                        </span>

                                    @else
                                        <span class="inline-flex rounded-full
                                                    bg-slate-100 px-2.5 py-1
                                                    text-xs font-medium text-slate-600">
                                            {{ $cita->estado }}
                                        </span>
                                    @endif
                                </td>

                                {{-- Mascota --}}
                                <td class="px-5 py-4 text-slate-800 font-medium whitespace-nowrap">
                                    {{ $cita->Mascota->nombre ?? 'Sin mascota' }}
                                </td>

                                {{-- Veterinario --}}
                                <td class="px-5 py-4 text-slate-700 whitespace-nowrap">
                                    {{ $cita->Veterinario->nombre ?? 'Sin asignar' }}
                                </td>

                                {{-- Servicio --}}
                                <td class="px-3 py-4 text-sm text-slate-700 break-words [overflow-wrap:anywhere]">
                                    {{ $cita->Servicio->nombre ?? 'Sin servicio' }}
                                </td>
                                
                                {{-- Acciones --}}
                                <td class="px-5 py-4">

                                    {{--
                                    @if($esVeterinarioAsignado || auth()->user()->hasRole('administrador'))
                                    --}}

                                    @if($esVeterinarioAsignado)
                                    
                                        <div class="mx-auto grid w-52 grid-cols-2 gap-2">

                                            @if($cita->estado === 'En atención')

                                                {{-- Cuando está en atención, solo puede continuar la consulta --}}
                                                <a href="{{ route('cita.show', $cita->id) }}"
                                                    class="col-span-2 inline-flex w-full items-center justify-center gap-1.5 rounded-lg bg-[#EAF4F5] px-2 py-2 text-xs font-semibold text-[#40899A] transition hover:bg-[#d5ebed]">

                                                    @include('layouts.partials.icons', ['icon' => 'historiaclinica'])

                                                    Continuar consulta
                                                </a>

                                            @elseif($cita->estado === 'Confirmada')

                                                {{-- Cancelar cita --}}
                                                <button type="button"
                                                    onclick="abrirModalCancelar(
                                                        {{ $cita->id }},
                                                        {{ Js::from($cita->Mascota->nombre ?? 'Sin mascota') }},
                                                        {{ Js::from($cita->fecha) }},
                                                        {{ Js::from($cita->hora) }},
                                                        {{ Js::from($cita->motivo ?? 'Sin motivo registrado') }}
                                                    )"
                                                    class="inline-flex w-full items-center justify-center gap-1.5 rounded-lg bg-amber-50 px-2 py-2 text-xs font-semibold text-amber-700 transition hover:bg-amber-100"
                                                    title="Cancelar cita">

                                                    <svg class="w-4 h-4" fill="none"
                                                        stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round"
                                                            stroke-linejoin="round" stroke-width="2"
                                                            d="M6 18 18 6M6 6l12 12"/>
                                                    </svg>

                                                    Cancelar
                                                </button>

                                                {{-- Atender --}}
                                                <a href="{{ route('cita.show', $cita->id) }}"
                                                    class="inline-flex w-full items-center justify-center gap-1.5 rounded-lg bg-[#EAF4F5] px-2 py-2 text-xs font-semibold text-[#40899A] transition hover:bg-[#d5ebed]">

                                                    @include('layouts.partials.icons', ['icon' => 'historiaclinica'])

                                                    Atender
                                                </a>

                                                {{-- Marcar inasistencia --}}
                                                <button type="button"
                                                    onclick="abrirModalInasistencia('{{ route('cita.noAsistio', $cita->id) }}')"
                                                    class="col-span-2 inline-flex w-full items-center justify-center gap-1.5 rounded-lg bg-slate-100 px-2 py-2 text-xs font-semibold text-slate-700 transition hover:bg-slate-200"
                                                    title="Marcar inasistencia">

                                                    <svg class="h-4 w-4" fill="none"
                                                        stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round"
                                                            stroke-linejoin="round" stroke-width="2"
                                                            d="M12 9v4m0 4h.01M10.3 3.9 2.6 17.2A2 2 0 0 0 4.3 20h15.4a2 2 0 0 0 1.7-2.8L13.7 3.9a2 2 0 0 0-3.4 0Z"/>
                                                    </svg>

                                                    No asistió
                                                </button>

                                            @else

                                                <span class="col-span-2 flex items-center justify-center py-2 text-xs text-slate-400">
                                                    Sin acciones
                                                </span>

                                            @endif

                                        </div>

                                    @else

                                        <div class="flex justify-center">

                                            @if($cita->estado === 'Confirmada')

                                                {{-- Acción centrada para administrador y usuario --}}
                                                <button type="button"
                                                    onclick="abrirModalCancelar(
                                                        {{ $cita->id }},
                                                        {{ Js::from($cita->Mascota->nombre ?? 'Sin mascota') }},
                                                        {{ Js::from($cita->fecha) }},
                                                        {{ Js::from($cita->hora) }},
                                                        {{ Js::from($cita->motivo ?? 'Sin motivo registrado') }}
                                                    )"
                                                    class="inline-flex items-center justify-center gap-1.5 rounded-lg bg-amber-50 px-3 py-2 text-xs font-semibold text-amber-700 transition hover:bg-amber-100"
                                                    title="Cancelar cita">

                                                    <svg class="w-4 h-4" fill="none"
                                                        stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round"
                                                            stroke-linejoin="round" stroke-width="2"
                                                            d="M6 18 18 6M6 6l12 12"/>
                                                    </svg>

                                                    Cancelar
                                                </button>

                                            @elseif($cita->estado === 'Cancelada')

                                                <button type="button"
                                                    onclick="abrirModalVerMotivo(
                                                        {{ Js::from($cita->Mascota->nombre ?? 'Sin mascota') }},
                                                        {{ Js::from($cita->fecha) }},
                                                        {{ Js::from($cita->hora) }},
                                                        {{ Js::from($cita->CancelacionCita->fechaCancelacion?->format('d/m/Y H:i') ?? 'Sin fecha') }},
                                                        {{ Js::from($cita->CancelacionCita->tipoCancelador ?? 'No registrado') }},
                                                        {{ Js::from($cita->CancelacionCita->motivo ?? 'No se registró un motivo de cancelación') }}
                                                    )"
                                                    class="inline-flex items-center justify-center gap-1.5 rounded-lg bg-blue-50 px-3 py-2 text-xs font-semibold text-blue-700 transition hover:bg-blue-100">

                                                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z"/>
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                            d="M2.5 12s3.5-7 9.5-7 9.5 7 9.5 7-3.5 7-9.5 7-9.5-7-9.5-7Z"/>
                                                    </svg>

                                                    Ver motivo
                                                </button>

                                            @else

                                                <span class="flex items-center justify-center py-2 text-xs text-slate-400">
                                                    Sin acciones
                                                </span>

                                            @endif

                                        </div>

                                    @endif

                                </td>

                            </tr>

                        @empty

                            @if ($hayFiltrosAplicados)

                                {{-- Sin resultados de búsqueda --}}
                                <tr>
                                    <td colspan="9" class="px-6 py-12 text-center">

                                        <h3 class="text-base font-semibold text-slate-700">
                                            No se encontraron resultados
                                        </h3>

                                        <p class="mt-1 text-sm text-slate-500">
                                            No hay citas que coincidan con los filtros aplicados.
                                        </p>

                                    </td>
                                </tr>

                            @else

                                {{-- Sin citas --}}
                                <tr>
                                    <td colspan="9" class="px-6 py-12 text-center">

                                        <div class="mx-auto w-14 h-14 rounded-full
                                                    bg-[#EAF4F5] text-[#40899A]
                                                    flex items-center justify-center">

                                            @include('layouts.partials.icons', [
                                                'icon' => 'cita'
                                            ])

                                        </div>

                                        <h3 class="mt-4 text-base font-semibold text-slate-800">
                                            No hay citas registradas
                                        </h3>

                                        <p class="mt-1 text-sm text-slate-500">
                                            Cuando registres una cita, aparecerá aquí.
                                        </p>

                                        <a href="{{ route('cita.create') }}"
                                            class="inline-flex items-center gap-2 mt-4
                                                rounded-lg bg-primary-600 px-4 py-2.5
                                                text-sm font-semibold text-white
                                                hover:bg-primary-700 transition">

                                            Registrar primera cita

                                        </a>

                                    </td>
                                </tr>

                            @endif

                        @endforelse

                    </tbody>
                </table>
            </div>


            {{-- Paginación --}}
            @if($citas->hasPages())
                <div class="border-t border-slate-200 bg-white px-4 py-4 sm:px-6">

                    <div class="flex flex-col gap-3 sm:flex-row
                                sm:items-center sm:justify-between">

                        <p class="text-sm text-slate-500">
                            Mostrando
                            <span class="font-semibold text-slate-700">
                                {{ $citas->firstItem() ?? 0 }}
                            </span>
                            a
                            <span class="font-semibold text-slate-700">
                                {{ $citas->lastItem() ?? 0 }}
                            </span>
                            de
                            <span class="font-semibold text-slate-700">
                                {{ $citas->total() }}
                            </span>
                            citas
                        </p>

                        <div>
                            {{ $citas->onEachSide(1)->links('vendor.pagination.gemas') }}
                        </div>

                    </div>

                </div>
            @endif

        </div>

        {{-- Vista de calendario --}}
        @include('Cita.partials.calendario')

    </div>

    {{-- Modal para cancelar una cita --}}
    <div id="modalCancelarCita"
        class="hidden fixed inset-0 z-50 flex items-center justify-center bg-slate-900/50 p-4">

        <div class="w-full max-w-md overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-2xl">

            {{-- Encabezado --}}
            <div class="flex items-center justify-between border-b border-slate-100 px-6 py-4">
                <h3 class="text-lg font-semibold text-slate-800">
                    Cancelar cita
                </h3>

                <button type="button"
                    onclick="cerrarModalCancelar()"
                    class="flex h-9 w-9 items-center justify-center rounded-lg text-slate-400 transition hover:bg-slate-100 hover:text-slate-700"
                    aria-label="Cerrar modal">
                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M6 18 18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>

            {{-- Contenido --}}
            <div class="px-6 py-6">

                <div class="mb-5 text-center">
                    <div class="mx-auto mb-4 flex h-16 w-16 items-center justify-center rounded-full bg-amber-100">
                        <svg class="h-8 w-8 text-amber-700" fill="none"
                            stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M6 7h12l-1 13H7L6 7Zm3 0V4h6v3M4 7h16"/>
                        </svg>
                    </div>

                    <h4 class="text-lg font-semibold text-slate-800">
                        ¿Deseas cancelar esta cita?
                    </h4>

                    <p class="mt-2 text-sm text-slate-500">
                        Esta acción cambiará el estado de la cita a cancelada.
                    </p>
                </div>

                {{-- Información de la cancelación --}}
                <div class="mb-5 space-y-4 rounded-xl border border-slate-200 bg-slate-50 p-4">

                    <div>
                        <p class="text-xs font-medium text-slate-500">Mascota</p>
                        <p id="mascotaCitaCancelar" class="text-sm font-semibold text-slate-800">
                            —
                        </p>
                    </div>

                    <div>
                        <p class="text-xs font-medium text-slate-500">Fecha de cancelación</p>
                        <p id="fechaCancelacionActual" class="text-sm font-semibold text-slate-800">
                            —
                        </p>
                    </div>

                </div>

                {{-- Motivo de cancelación --}}
                <form id="formCancelarCita"
                    action="{{ route('cancelacioncita.store') }}"
                    method="POST">

                    @csrf

                    <input type="hidden" name="idCita" id="idCitaCancelar">

                    <label for="motivoCancelacion" class="mb-2 block text-sm font-semibold text-slate-800">
                        Motivo de la cancelación
                        <span class="text-red-500">*</span>
                    </label>

                    <textarea
                        id="motivoCancelacion"
                        name="motivo"
                        rows="3"
                        required
                        maxlength="250"
                        placeholder="Escribe el motivo por el que deseas cancelar la cita..."
                        class="w-full resize-none rounded-lg border border-slate-300 bg-white px-4 py-3 text-sm text-slate-700 placeholder:text-slate-400 focus:border-primary-500 focus:outline-none focus:ring-2 focus:ring-primary-100"></textarea>

                    <p class="mt-1.5 text-xs text-slate-500">
                        Campo obligatorio. Máximo 250 caracteres.
                    </p>

                    {{-- Botones --}}
                    <div class="mt-5 flex flex-col-reverse gap-3 sm:flex-row sm:justify-end">

                        <button type="button"
                            onclick="cerrarModalCancelar()"
                            class="rounded-lg border border-slate-300 px-4 py-2.5 text-sm font-semibold text-slate-700 transition hover:bg-slate-50">
                            Volver
                        </button>

                        <button type="submit"
                            class="rounded-lg bg-amber-700 px-4 py-2.5 text-sm font-semibold text-white transition hover:bg-amber-800">
                            Sí, cancelar cita
                        </button>

                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- Modal para consultar el motivo de cancelación --}}
    <div id="modalVerMotivo"
        class="hidden fixed inset-0 z-50 flex items-center justify-center bg-slate-900/50 p-4">

        <div class="w-full max-w-md overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-2xl">

            {{-- Encabezado --}}
            <div class="flex items-center justify-between border-b border-slate-100 px-6 py-4">

                <h3 class="text-lg font-semibold text-slate-800">
                    Detalles de la cancelación
                </h3>

                <button type="button"
                    onclick="cerrarModalVerMotivo()"
                    class="flex h-9 w-9 items-center justify-center rounded-lg text-slate-400 transition hover:bg-slate-100 hover:text-slate-700"
                    aria-label="Cerrar modal">

                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M6 18 18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>

            {{-- Información --}}
            <div class="space-y-5 px-6 py-6">

                {{-- Mascota --}}
                <div>
                    <p class="text-xs font-medium text-slate-500">Mascota</p>
                    <p id="mascotaVerMotivo" class="mt-1 text-sm font-semibold text-slate-800">
                        —
                    </p>
                </div>

                {{-- Fecha y hora de la cita --}}
                <div class="grid grid-cols-2 gap-4">

                    <div>
                        <p class="text-xs font-medium text-slate-500">Fecha de la cita</p>
                        <p id="fechaVerMotivo" class="mt-1 text-sm font-semibold text-slate-800">
                            —
                        </p>
                    </div>

                    <div>
                        <p class="text-xs font-medium text-slate-500">Hora de la cita</p>
                        <p id="horaVerMotivo" class="mt-1 text-sm font-semibold text-slate-800">
                            —
                        </p>
                    </div>

                </div>

                {{-- Fecha de cancelación --}}
                <div>
                    <p class="text-xs font-medium text-slate-500">Fecha de cancelación</p>
                    <p id="fechaVerCancelacion" class="mt-1 text-sm font-semibold text-slate-800">
                        —
                    </p>
                </div>

                {{-- Quien cancelo --}}
                <div>
                    <p class="text-xs font-medium text-slate-500">Cancelada por</p>
                    <p id="tipoCanceladorVer" class="mt-1 text-sm font-semibold text-slate-800">
                        —
                    </p>
                </div>

                {{-- Motivo --}}
                <div class="rounded-xl border border-blue-100 bg-blue-50 p-4">

                    <p class="mb-2 text-sm font-semibold text-blue-800">
                        Motivo de la cancelación
                    </p>

                    <p id="textoVerMotivo"
                        class="whitespace-pre-line break-words text-sm leading-6 text-slate-700">
                        —
                    </p>
                </div>

            </div>

            {{-- Pie del modal --}}
            <div class="flex justify-end border-t border-slate-100 px-6 py-4">

                <button type="button"
                    onclick="cerrarModalVerMotivo()"
                    class="rounded-lg bg-slate-800 px-5 py-2.5 text-sm font-semibold text-white transition hover:bg-slate-700">
                    Cerrar
                </button>

            </div>
        </div>
    </div>

    {{-- Modal para confirmar inasistencia --}}
    <div id="modalInasistencia"
        class="hidden fixed inset-0 z-50 flex items-center justify-center bg-black/50 p-4">

        <div class="w-full max-w-md rounded-xl bg-white shadow-xl">

            {{-- Encabezado --}}
            <div class="flex items-center gap-3 border-b border-slate-200 px-6 py-4">

                <div class="flex h-10 w-10 items-center justify-center rounded-full bg-amber-100 text-amber-600">
                    <svg class="h-5 w-5" fill="none"
                        stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round"
                            stroke-linejoin="round" stroke-width="2"
                            d="M12 9v4m0 4h.01M10.3 3.9 2.6 17.2A2 2 0 0 0 4.3 20h15.4a2 2 0 0 0 1.7-2.8L13.7 3.9a2 2 0 0 0-3.4 0Z"/>
                    </svg>
                </div>

                <div>
                    <h3 class="text-lg font-semibold text-slate-800">
                        Confirmar inasistencia
                    </h3>

                    <p class="text-sm text-slate-500">
                        Registrar mascota como ausente
                    </p>
                </div>
            </div>

            {{-- Contenido --}}
            <div class="px-6 py-5">
                <p class="text-sm leading-relaxed text-slate-600">
                    ¿Estás seguro de que deseas marcar esta cita como
                    <span class="font-semibold text-slate-800">No asistió</span>?
                    Esta acción cambiará el estado de la cita.
                </p>
            </div>

            {{-- Botones --}}
            <div class="flex justify-end gap-3 border-t border-slate-200 px-6 py-4">

                <button type="button"
                    onclick="cerrarModalInasistencia()"
                    class="rounded-lg border border-slate-300 px-4 py-2
                        text-sm font-semibold text-slate-600
                        transition hover:bg-slate-100">
                    Cancelar
                </button>

                <form id="formInasistencia" method="POST">
                    @csrf

                    <button type="submit"
                        class="rounded-lg bg-amber-500 px-4 py-2
                            text-sm font-semibold text-white
                            transition hover:bg-amber-600">
                        Confirmar inasistencia
                    </button>
                </form>

            </div>
        </div>
    </div>
    
    {{-- Modal de aviso --}}
    @if(session()->has('error'))

        @php
            $esError = session('tipoAviso') === 'error';

            $colorAviso = $esError
                ? [
                    'contenedor' => 'bg-red-100',
                    'icono' => 'text-red-600',
                    'titulo' => 'No se pudo realizar la acción',
                    'boton' => 'bg-red-600 hover:bg-red-700',
                ]
                : [
                    'contenedor' => 'bg-amber-100',
                    'icono' => 'text-amber-600',
                    'titulo' => 'Ten en cuenta',
                    'boton' => 'bg-amber-600 hover:bg-amber-700',
                ];
        @endphp

        <div id="modalAviso"
            class="fixed inset-0 z-[100] flex items-center
                justify-center bg-slate-900/50 p-4">

            <div class="w-full max-w-md overflow-hidden
                        rounded-2xl border border-slate-200
                        bg-white shadow-2xl">

                {{-- Encabezado --}}
                <div class="flex items-center gap-3
                            border-b border-slate-100 px-6 py-5">

                    <div class="flex h-12 w-12 shrink-0
                                items-center justify-center rounded-full
                                {{ $colorAviso['contenedor'] }}">

                        @if($esError)

                            <svg class="h-6 w-6 {{ $colorAviso['icono'] }}"
                                fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">

                                <path stroke-linecap="round"
                                    stroke-linejoin="round" stroke-width="2"
                                    d="M12 9v4m0 4h.01M10.3 3.9 2.6 17.2A2 2 0 0 0 4.3 20h15.4a2 2 0 0 0 1.7-2.8L13.7 3.9a2 2 0 0 0-3.4 0Z"/>

                            </svg>

                        @else

                            <svg class="h-6 w-6 {{ $colorAviso['icono'] }}"
                                fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">

                                <path stroke-linecap="round"
                                    stroke-linejoin="round" stroke-width="2"
                                    d="M12 8v4m0 4h.01M12 3a9 9 0 1 0 0 18 9 9 0 0 0 0-18Z"/>

                            </svg>

                        @endif

                    </div>

                    <div>
                        <h3 class="text-lg font-semibold text-slate-800">
                            {{ $colorAviso['titulo'] }}
                        </h3>

                        <p class="mt-0.5 text-sm text-slate-500">
                            Información sobre la cita
                        </p>
                    </div>

                </div>

                {{-- Mensaje --}}
                <div class="px-6 py-6">

                    <p class="text-sm leading-6 text-slate-600">
                        {{ session('error') }}
                    </p>

                </div>

                {{-- Botón --}}
                <div class="flex justify-end border-t
                            border-slate-100 px-6 py-4">

                    <button type="button"
                        onclick="cerrarModalAviso()"
                        class="rounded-lg px-5 py-2.5
                            text-sm font-semibold text-white
                            transition {{ $colorAviso['boton'] }}">

                        Entendido

                    </button>

                </div>

            </div>

        </div>

    @endif
  
    <script>
        // Modal para cancelar una cita
        function abrirModalCancelar(id, mascota) {
            document.getElementById('idCitaCancelar').value = id;

            document.getElementById('mascotaCitaCancelar').textContent =
                mascota || 'Sin mascota';

            document.getElementById('fechaCancelacionActual').textContent =
                new Date().toLocaleDateString('es-CO', {
                    day: '2-digit',
                    month: '2-digit',
                    year: 'numeric'
                });

            document.getElementById('motivoCancelacion').value = '';

            document.getElementById('modalCancelarCita').classList.remove('hidden');
        }

        function cerrarModalCancelar() {
            document.getElementById('modalCancelarCita')?.classList.add('hidden');
        }


        // Modal para consultar el motivo de cancelación
        function abrirModalVerMotivo(
            mascota,
            fecha,
            hora,
            fechaCancelacion,
            tipoCancelador,
            motivo
        ) {
            document.getElementById('mascotaVerMotivo').textContent =
                mascota || 'Sin mascota';

            document.getElementById('fechaVerMotivo').textContent =
                fecha ? fecha.split('-').reverse().join('/') : 'Sin fecha';

            document.getElementById('horaVerMotivo').textContent =
                hora || 'Sin hora';

            document.getElementById('fechaVerCancelacion').textContent =
                fechaCancelacion || 'Sin fecha';

            document.getElementById('tipoCanceladorVer').textContent =
                tipoCancelador || 'No registrado';

            document.getElementById('textoVerMotivo').textContent =
                motivo || 'No se registró un motivo de cancelación';

            document.getElementById('modalVerMotivo').classList.remove('hidden');
        }

        function cerrarModalVerMotivo() {
            document.getElementById('modalVerMotivo')?.classList.add('hidden');
        }


        // Modal para registrar una inasistencia
        function abrirModalInasistencia(url) {
            document.getElementById('formInasistencia').action = url;

            document.getElementById('modalInasistencia').classList.remove('hidden');
        }

        function cerrarModalInasistencia() {
            document.getElementById('modalInasistencia')?.classList.add('hidden');
        }


        // Modal de aviso
        function cerrarModalAviso() {
            const modal = document.getElementById('modalAviso');

            if (modal) {
                modal.classList.add('hidden');
            }
        }

        window.cerrarModalAviso = function () {
            const modal = document.getElementById('modalAviso');

            if (modal) {
                modal.remove();
            }
        };


        // Inicialización de eventos al cargar la página
        document.addEventListener('DOMContentLoaded', function () {

            // Cerrar modales al hacer clic fuera de su contenido.
            const modales = [
                'modalCancelarCita',
                'modalVerMotivo',
                'modalInasistencia'
            ];

            modales.forEach(function (idModal) {
                const modal = document.getElementById(idModal);

                if (modal) {
                    modal.addEventListener('click', function (event) {
                        if (event.target === modal) {
                            modal.classList.add('hidden');
                        }
                    });
                }
            });


            //Filtros

            const buscarCita = document.getElementById('buscarCita');
            const filtroEstado = document.getElementById('filtroEstado');
            const filtroFecha = document.getElementById('filtroFecha');

            const contadorCitas = document.getElementById('contadorCitas');
            const sinResultados = document.getElementById('sinResultadosCitas');

            const botonLimpiarGeneral =
                document.getElementById('limpiarFiltrosCitas');


            // Aplicar filtros desde el botón.
            botonAplicarFiltros?.addEventListener('click', filtrarCitas);


            // Limpiar todos los filtros.
            function limpiarFiltrosCitas() {

                if (buscarCita) {
                    buscarCita.value = '';
                }

                if (filtroEstado) {
                    filtroEstado.value = '';
                }

                if (filtroFecha) {
                    filtroFecha.value = '';
                }

                filtrarCitas();
            }


            botonLimpiarGeneral?.addEventListener(
                'click',
                limpiarFiltrosCitas
            );


        });

    </script>

@endsection
