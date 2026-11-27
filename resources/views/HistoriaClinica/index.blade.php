@extends('layouts.app')

@section('title')
    Historias clínicas - Gemas
@endsection

@section('content')

    <div class="w-full max-w-7xl mx-auto space-y-6"
        x-data="{
            mostrarModal: false,
            historia: {},

            abrirHistoria(datos) {
                this.historia = datos;
                this.mostrarModal = true;
            }
        }">

        {{-- Encabezado --}}
        <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">

            <div>
                <h1 class="text-2xl font-bold text-slate-800">
                    Historias clínicas
                </h1>

                <p class="mt-1 text-sm text-slate-500">
                    Consulta la información clínica de las mascotas registradas.
                </p>
            </div>

            @if(auth()->user()->tieneRolActivo('administrador') || auth()->user()->tieneRolActivo('veterinario'))

                <a href="{{ route('historiaclinica.create') }}"
                    class="inline-flex items-center justify-center gap-2 rounded-xl
                        bg-[#40899A] px-5 py-3 text-sm font-semibold text-white
                        shadow-sm transition hover:bg-[#347787]">

                    <svg class="h-5 w-5" fill="none" stroke="currentColor"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            stroke-width="2" d="M12 4v16m8-8H4"/>
                    </svg>

                    Completar historias pendientes
                </a>

            @endif

        </div>

        {{-- Mensajes del sistema --}}
        @if(session('success') || session('sucess'))
            <div class="rounded-lg border border-green-200
                        bg-green-50 px-4 py-3 text-sm text-green-700">
                {{ session('success') ?? session('sucess') }}
            </div>
        @endif

        @if(session('update'))
            <div class="rounded-lg border border-blue-200
                        bg-blue-50 px-4 py-3 text-sm text-blue-700">
                {{ session('update') }}
            </div>
        @endif

        @if(session('error'))
            <div class="rounded-lg border border-red-200
                        bg-red-50 px-4 py-3 text-sm text-red-700">
                {{ session('error') }}
            </div>
        @endif

        {{-- Filtros --}}
        <x-filtros-tabla
            buscador-id="buscarHistoria"
            placeholder="Nombre de la mascota..."
            contador-id="contadorHistorias"
            limpiar-id="limpiarFiltrosHistorias"
            :contador-total="$historiasClinicas->total()"
            :filtros="[
                [
                    'id' => 'filtroEstado',
                    'name' => 'estado',
                    'label' => 'Estado',
                    'todos' => 'Todos los estados',
                    'opciones' => [
                        'completa' => 'Completa',
                        'pendiente' => 'Pendiente'
                    ]
                ],
                [
                    'id' => 'filtroFecha',
                    'name' => 'fecha',
                    'label' => 'Fecha de apertura',
                    'tipo' => 'date'
                ]
            ]"
        />

        {{-- Tabla de historias clínicas --}}
        <div class="overflow-hidden rounded-xl border border-slate-200 bg-white shadow-sm">

            {{-- Encabezado de la tabla --}}
            <div class="border-b border-slate-200 px-6 py-5">
                <h2 class="text-lg font-semibold text-slate-800">
                    Historias clínicas registradas
                </h2>

                <p class="mt-1 text-sm text-slate-500">
                    Listado de las historias clínicas y su estado de actualización.
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
                                Mascota
                            </th>

                            <th class="px-6 py-3 font-medium">
                                Especie / Raza
                            </th>

                            <th class="px-6 py-3 font-medium">
                                Fecha de apertura
                            </th>

                            <th class="px-6 py-3 font-medium">
                                Estado
                            </th>

                            <th class="px-6 py-3 font-medium text-center">
                                Evoluciones
                            </th>

                            <th class="px-6 py-3 font-medium text-center">
                                Acciones
                            </th>

                        </tr>
                    </thead>

                    <tbody class="divide-y divide-slate-100">

                        @forelse($historiasClinicas as $historiaClinica)

                            <tr class="transition hover:bg-slate-50">

                                {{-- ID --}}
                                @if(auth()->user()->hasRole('administrador'))
                                    <td class="px-6 py-4 text-slate-500">
                                        {{ $historiaClinica->id }}
                                    </td>
                                @endif

                                {{-- Mascota --}}
                                <td class="px-6 py-4">

                                    <div class="font-medium text-slate-700">
                                        {{ $historiaClinica->Mascota?->nombre
                                            ?? 'Mascota no disponible' }}
                                    </div>

                                    <p class="mt-1 text-xs text-slate-400">
                                        Historia clínica #{{ $historiaClinica->id }}
                                    </p>

                                </td>

                                {{-- Especie y raza --}}
                                <td class="px-6 py-4">

                                    <p class="font-medium text-slate-700">
                                        {{ $historiaClinica->Mascota?->especie ?? 'No registrada' }}
                                    </p>

                                    <p class="mt-1 text-xs text-slate-400">
                                        {{ $historiaClinica->Mascota?->raza ?? 'Raza no registrada' }}
                                    </p>

                                </td>

                                {{-- Fecha de apertura --}}
                                <td class="px-6 py-4 text-slate-700">
                                    {{ $historiaClinica->fechaApertura
                                        ? \Carbon\Carbon::parse($historiaClinica->fechaApertura)->format('d/m/Y')
                                        : 'No registrada' }}
                                </td>

                                {{-- Estado --}}
                                <td class="px-6 py-4">

                                    @if($historiaClinica->completadaEn === null)

                                        <span class="inline-flex items-center gap-1.5 rounded-full
                                                    bg-amber-50 px-3 py-1 text-xs
                                                    font-semibold text-amber-700">

                                            <span class="h-1.5 w-1.5 rounded-full bg-amber-500"></span>

                                            Pendiente
                                        </span>

                                    @else

                                        <span class="inline-flex items-center gap-1.5 rounded-full
                                                    bg-green-50 px-3 py-1 text-xs
                                                    font-semibold text-green-700">

                                            <span class="h-1.5 w-1.5 rounded-full bg-green-500"></span>

                                            Completa
                                        </span>

                                    @endif

                                </td>

                                {{-- Evoluciones --}}
                                <td class="px-6 py-4 text-center">

                                    <span class="inline-flex min-w-8 items-center justify-center
                                                rounded-lg bg-[#EAF4F5] px-2.5 py-1
                                                text-xs font-semibold text-[#40899A]">
                                        {{ $historiaClinica->Evolucion->count() }}
                                    </span>

                                </td>

                                {{-- Acciones --}}
                                <td class="px-6 py-4">

                                    <div class="flex items-center justify-center gap-2">

                                        {{-- Ver historia clínica --}}
                                        <button
                                            type="button"
                                            @click="abrirHistoria({
                                                id: @js($historiaClinica->id),
                                                mascota: @js($historiaClinica->Mascota?->nombre ?? 'Mascota no disponible'),
                                                especie: @js($historiaClinica->Mascota?->especie ?? 'No registrada'),
                                                raza: @js($historiaClinica->Mascota?->raza ?? 'No registrada'),
                                                fecha: @js($historiaClinica->fechaApertura ? \Carbon\Carbon::parse($historiaClinica->fechaApertura)->format('d/m/Y') : 'No registrada'),
                                                estado: @js($historiaClinica->completadaEn ? 'Completa' : 'Pendiente'),
                                                completada: @js($historiaClinica->completadaEn ? \Carbon\Carbon::parse($historiaClinica->completadaEn)->format('d/m/Y H:i') : null),
                                                antecedentes: @js($historiaClinica->antecedentes),
                                                alergias: @js($historiaClinica->alergias),
                                                enfermedades: @js($historiaClinica->enfermedadesPrevias),
                                                observaciones: @js($historiaClinica->observaciones),
                                                evoluciones: @js(
                                                    $historiaClinica->Evolucion
                                                        ->map(fn ($evolucion) => $evolucion->toArray())
                                                        ->values()
                                                )
                                            })"
                                            class="inline-flex h-9 w-9 items-center justify-center
                                                rounded-lg bg-[#EAF4F5] text-[#40899A]
                                                transition hover:bg-[#d5ebed]"
                                            title="Ver historia clínica">

                                            <svg class="h-4 w-4" fill="none"
                                                stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round"
                                                    stroke-linejoin="round" stroke-width="1.8"
                                                    d="M2.25 12s3.5-7 9.75-7 9.75 7
                                                        9.75 7-3.5 7-9.75 7-9.75-7-9.75-7Z"/>
                                                <circle cx="12" cy="12" r="3"
                                                    stroke-width="1.8"/>
                                            </svg>

                                        </button>

                                        {{-- Descargar PDF --}}
                                        <a href="{{ route('historiaclinica.pdf', $historiaClinica->id) }}"
                                            class="inline-flex h-9 w-9 items-center justify-center
                                                rounded-lg bg-red-50 text-red-600
                                                transition hover:bg-red-100"
                                            title="Descargar historia clínica en PDF">

                                            <svg class="h-4 w-4" fill="none"
                                                stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round"
                                                    stroke-linejoin="round" stroke-width="1.8"
                                                    d="M12 3v12m0 0 4-4m-4 4-4-4
                                                    M4 17v3h16v-3"/>
                                            </svg>

                                        </a>

                                        {{-- Completar historia clínica --}}
                                        @if($historiaClinica->completadaEn === null && !auth()->user()->tieneRolActivo('usuario'))

                                            <a href="{{ route('historiaclinica.edit', $historiaClinica->id) }}"
                                                class="inline-flex h-9 w-9 items-center justify-center
                                                    rounded-lg bg-emerald-50 text-emerald-600
                                                    transition hover:bg-emerald-100"
                                                title="Completar historia clínica">

                                                <svg class="h-4 w-4" fill="none"
                                                    stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round"
                                                        stroke-linejoin="round" stroke-width="1.8"
                                                        d="M12 4v16m8-8H4"/>
                                                </svg>

                                            </a>

                                        @endif

                                    </div>

                                </td>

                            </tr>

                        @empty

                            @if ($hayFiltrosAplicados)

                                {{-- Sin resultados de búsqueda --}}
                                <tr>
                                    <td colspan="{{ auth()->user()->hasRole('administrador') ? 7 : 6 }}"
                                        class="px-6 py-10 text-center">

                                        <h3 class="text-lg font-semibold text-slate-700">
                                            No se encontraron resultados
                                        </h3>

                                        <p class="mt-1 text-sm text-slate-500">
                                            No hay historias clínicas que coincidan con los filtros aplicados.
                                        </p>

                                    </td>
                                </tr>

                            @else

                                {{-- Sin historias clínicas --}}
                                <tr>
                                    <td colspan="{{ auth()->user()->hasRole('administrador') ? 7 : 6 }}"
                                        class="px-6 py-10 text-center">

                                        <div class="mx-auto flex h-16 w-16 items-center justify-center
                                                    rounded-full bg-[#EAF4F5] text-[#40899A]">

                                            @include('layouts.partials.icons', [
                                                'icon' => 'historiaclinica'
                                            ])

                                        </div>

                                        <h3 class="mt-4 text-lg font-semibold text-slate-800">
                                            No hay historias clínicas registradas
                                        </h3>

                                        <p class="mt-2 text-sm text-slate-500">
                                            Las historias clínicas de las mascotas aparecerán aquí.
                                        </p>

                                        @if(auth()->user()->can('crearhistoria'))
                                            <a href="{{ route('historiaclinica.create') }}"
                                                class="mt-5 inline-flex items-center gap-2 rounded-lg
                                                    bg-[#40899A] px-4 py-2.5 text-sm font-semibold
                                                    text-white transition hover:bg-[#347787]">

                                                Completar primera historia clínica

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
        @if($historiasClinicas->hasPages())

            <div class="border-t border-slate-200 bg-white px-4 py-4 sm:px-6">

                <div class="flex flex-col gap-3 sm:flex-row
                            sm:items-center sm:justify-between">

                    <p class="text-sm text-slate-500">
                        Mostrando
                        <span class="font-semibold text-slate-700">
                            {{ $historiasClinicas->firstItem() ?? 0 }}
                        </span>
                        a
                        <span class="font-semibold text-slate-700">
                            {{ $historiasClinicas->lastItem() ?? 0 }}
                        </span>
                        de
                        <span class="font-semibold text-slate-700">
                            {{ $historiasClinicas->total() }}
                        </span>
                        historias clínicas
                    </p>

                    <div>
                        {{ $historiasClinicas->onEachSide(1)->links('vendor.pagination.gemas') }}
                    </div>

                </div>

            </div>

        @endif


        {{-- Modal: información de historia clínica --}}
        <div
            x-cloak
            x-show="mostrarModal"
            x-transition.opacity
            @keydown.escape.window="mostrarModal = false"
            @click.self="mostrarModal = false"
            class="fixed inset-0 z-50 flex items-center justify-center
                bg-slate-900/50 p-4">

            <div
                x-show="mostrarModal"
                x-transition
                class="flex max-h-[90vh] w-full max-w-3xl flex-col
                    overflow-hidden rounded-2xl bg-white shadow-xl">

                {{-- Encabezado --}}
                <div class="flex items-center justify-between gap-4
                            border-b border-slate-100 px-6 py-5">

                    <div class="flex items-center gap-3">

                        <div class="flex h-11 w-11 shrink-0 items-center
                                    justify-center rounded-xl bg-[#EAF4F5]
                                    text-[#40899A]">

                            @include('layouts.partials.icons', [
                                'icon' => 'historiaclinica'
                            ])

                        </div>

                        <div>
                            <h2 class="text-lg font-bold text-slate-800">
                                Historia clínica
                            </h2>

                            <p class="mt-1 text-sm text-slate-500">
                                Información médica y seguimiento de la mascota.
                            </p>
                        </div>

                    </div>

                    <button type="button"
                        @click="mostrarModal = false"
                        class="flex h-9 w-9 shrink-0 items-center justify-center
                            rounded-lg text-slate-500 transition hover:bg-slate-100"
                        title="Cerrar">

                        <svg class="h-5 w-5" fill="none"
                            stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round"
                                stroke-linejoin="round" stroke-width="2"
                                d="M6 18 18 6M6 6l12 12"/>
                        </svg>

                    </button>

                </div>

                {{-- Contenido desplazable --}}
                <div class="flex-1 space-y-6 overflow-y-auto px-6 py-5">

                    {{-- Información general --}}
                    <div>
                        <div class="mb-4 flex items-center justify-between gap-3">

                            <h3 class="text-sm font-semibold text-slate-800">
                                Información general
                            </h3>

                            <span
                                class="rounded-full px-3 py-1 text-xs font-semibold"
                                :class="historia.estado === 'Completa'
                                    ? 'bg-green-50 text-green-700'
                                    : 'bg-amber-50 text-amber-700'"
                                x-text="historia.estado">
                            </span>

                        </div>

                        <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">

                            <div class="rounded-xl bg-slate-50 p-4">
                                <p class="text-xs font-medium text-slate-500">
                                    Numero de historia clínica
                                </p>
                                <p class="mt-1 font-semibold text-slate-800"
                                    x-text="historia.id"></p>
                            </div>

                            <div class="rounded-xl bg-slate-50 p-4">
                                <p class="text-xs font-medium text-slate-500">
                                    Mascota
                                </p>
                                <p class="mt-1 font-semibold text-slate-800"
                                    x-text="historia.mascota"></p>
                            </div>

                            <div class="rounded-xl bg-slate-50 p-4">
                                <p class="text-xs font-medium text-slate-500">
                                    Especie
                                </p>
                                <p class="mt-1 font-semibold text-slate-800"
                                    x-text="historia.especie"></p>
                            </div>

                            <div class="rounded-xl bg-slate-50 p-4">
                                <p class="text-xs font-medium text-slate-500">
                                    Raza
                                </p>
                                <p class="mt-1 font-semibold text-slate-800"
                                    x-text="historia.raza"></p>
                            </div>

                            <div class="rounded-xl bg-slate-50 p-4">
                                <p class="text-xs font-medium text-slate-500">
                                    Fecha de apertura
                                </p>
                                <p class="mt-1 font-semibold text-slate-800"
                                    x-text="historia.fecha"></p>
                            </div>

                            <div class="rounded-xl bg-slate-50 p-4">
                                <p class="text-xs font-medium text-slate-500">
                                    Fecha de finalización
                                </p>
                                <p class="mt-1 font-semibold text-slate-800"
                                    x-text="historia.completada || 'Pendiente de completar'"></p>
                            </div>

                        </div>
                    </div>

                    {{-- Antecedentes médicos --}}
                    <div class="border-t border-slate-100 pt-5">

                        <div class="mb-4">
                            <h3 class="text-sm font-semibold text-slate-800">
                                Antecedentes médicos
                            </h3>

                            <p class="mt-1 text-xs text-slate-500">
                                Información médica previa de la mascota.
                            </p>
                        </div>

                        <div class="space-y-4">

                            <div>
                                <p class="text-sm font-medium text-slate-700">
                                    Antecedentes
                                </p>

                                <p class="mt-1 whitespace-pre-line break-words
                                    text-sm leading-relaxed text-slate-500"
                                    x-text="historia.antecedentes || 'Sin información registrada'">
                                </p>
                            </div>

                            <div>
                                <p class="text-sm font-medium text-slate-700">
                                    Alergias
                                </p>

                                <p class="mt-1 whitespace-pre-line break-words
                                    text-sm leading-relaxed text-slate-500"
                                    x-text="historia.alergias || 'Sin información registrada'">
                                </p>
                            </div>

                            <div>
                                <p class="text-sm font-medium text-slate-700">
                                    Enfermedades previas
                                </p>

                                <p class="mt-1 whitespace-pre-line break-words
                                    text-sm leading-relaxed text-slate-500"
                                    x-text="historia.enfermedades || 'Sin información registrada'">
                                </p>
                            </div>

                            <div>
                                <p class="text-sm font-medium text-slate-700">
                                    Observaciones generales
                                </p>

                                <p class="mt-1 whitespace-pre-line break-words
                                    text-sm leading-relaxed text-slate-500"
                                    x-text="historia.observaciones || 'Sin información registrada'">
                                </p>
                            </div>

                        </div>
                    </div>

                    {{-- Evoluciones clínicas --}}
                    <div class="border-t border-slate-100 pt-5">

                        <div class="mb-4 flex items-center gap-3">

                            <div class="flex h-10 w-10 shrink-0 items-center
                                        justify-center rounded-xl bg-[#EAF4F5]
                                        text-[#40899A]">

                                <svg class="h-5 w-5" fill="none"
                                    stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round"
                                        stroke-linejoin="round" stroke-width="2"
                                        d="M3 12h4l3-8 4 16 3-8h4"/>
                                </svg>

                            </div>

                            <div>
                                <h3 class="text-sm font-semibold text-slate-800">
                                    Evoluciones clínicas
                                </h3>

                                <p class="mt-1 text-xs text-slate-500">
                                    Seguimiento médico de la mascota.
                                </p>
                            </div>

                        </div>

                        <template x-if="historia.evoluciones && historia.evoluciones.length > 0">

                            <div class="space-y-4">

                                <template x-for="(evolucion, indice) in historia.evoluciones"
                                    :key="evolucion.id ?? indice">

                                    <div class="overflow-hidden rounded-xl border border-slate-200">

                                        <div class="flex flex-wrap items-center
                                                    justify-between gap-2
                                                    border-b border-slate-100
                                                    bg-slate-50 px-4 py-3">

                                            <span class="text-sm font-semibold text-slate-800"
                                                x-text="'Evolución ' + (indice + 1)">
                                            </span>

                                            <span class="rounded-full bg-[#EAF4F5]
                                                        px-3 py-1 text-xs font-semibold
                                                        text-[#40899A]"
                                                x-text="evolucion.fecha || 'Fecha no registrada'">
                                            </span>

                                        </div>

                                        <div class="space-y-4 p-4">

                                            {{-- Datos de la evolución --}}
                                            <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">

                                                <div>
                                                    <p class="text-xs font-medium text-slate-500">
                                                        Peso
                                                    </p>

                                                    <p class="mt-1 text-sm font-medium text-slate-700"
                                                        x-text="evolucion.peso != null ? evolucion.peso + ' kg' : 'Sin registro'">
                                                    </p>
                                                </div>

                                                <div>
                                                    <p class="text-xs font-medium text-slate-500">
                                                        Temperatura
                                                    </p>

                                                    <p class="mt-1 text-sm font-medium text-slate-700"
                                                        x-text="evolucion.temperatura != null ? evolucion.temperatura + ' °C' : 'Sin registro'">
                                                    </p>
                                                </div>

                                            </div>

                                            {{-- Veterinario --}}
                                            <div>
                                                <p class="text-xs font-medium text-slate-500">
                                                    Veterinario responsable
                                                </p>

                                                <p class="mt-1 text-sm text-slate-700"
                                                    x-text="evolucion.veterinario?.nombre || 'No registrado'">
                                                </p>
                                            </div>

                                            {{-- Síntomas --}}
                                            <div>
                                                <p class="text-xs font-medium text-slate-500">
                                                    Síntomas
                                                </p>

                                                <p class="mt-1 whitespace-pre-line break-words
                                                    text-sm text-slate-600"
                                                    x-text="evolucion.sintomas || 'Sin información registrada'">
                                                </p>
                                            </div>

                                            {{-- Observaciones --}}
                                            <div>
                                                <p class="text-xs font-medium text-slate-500">
                                                    Observaciones
                                                </p>

                                                <p class="mt-1 whitespace-pre-line break-words
                                                    text-sm text-slate-600"
                                                    x-text="evolucion.observaciones || 'Sin información registrada'">
                                                </p>
                                            </div>

                                            {{-- Diagnósticos y tratamientos --}}
                                            <div class="border-t border-slate-100 pt-4">

                                                <h4 class="mb-3 text-sm font-semibold text-slate-800">
                                                    Diagnósticos y tratamientos
                                                </h4>

                                                <template x-if="evolucion.diagnostico_tratamiento &&
                                                    evolucion.diagnostico_tratamiento.length > 0">

                                                    <div class="space-y-3">

                                                        <template x-for="(registro, indiceDiagnostico) in evolucion.diagnostico_tratamiento"
                                                            :key="registro.id ?? indiceDiagnostico">

                                                            <div class="rounded-xl bg-slate-50 p-4">

                                                                <div>
                                                                    <p class="text-xs font-medium text-slate-500">
                                                                        Diagnóstico
                                                                    </p>

                                                                    <p class="mt-1 text-sm font-semibold text-slate-800"
                                                                        x-text="registro.diagnostico || 'No registrado'">
                                                                    </p>
                                                                </div>

                                                                <div class="mt-3">
                                                                    <p class="text-xs font-medium text-slate-500">
                                                                        Tratamiento
                                                                    </p>

                                                                    <p class="mt-1 whitespace-pre-line break-words
                                                                        text-sm text-slate-700"
                                                                        x-text="registro.tratamiento || 'Sin tratamiento registrado'">
                                                                    </p>
                                                                </div>

                                                                <div class="mt-3 grid grid-cols-1 gap-3 sm:grid-cols-2">

                                                                    <template x-if="registro.medicamento">
                                                                        <div>
                                                                            <p class="text-xs font-medium text-slate-500">
                                                                                Medicamento
                                                                            </p>
                                                                            <p class="mt-1 text-sm text-slate-700"
                                                                                x-text="registro.medicamento"></p>
                                                                        </div>
                                                                    </template>

                                                                    <template x-if="registro.dosis">
                                                                        <div>
                                                                            <p class="text-xs font-medium text-slate-500">
                                                                                Dosis
                                                                            </p>
                                                                            <p class="mt-1 text-sm text-slate-700"
                                                                                x-text="registro.dosis"></p>
                                                                        </div>
                                                                    </template>

                                                                    <template x-if="registro.frecuencia">
                                                                        <div>
                                                                            <p class="text-xs font-medium text-slate-500">
                                                                                Frecuencia
                                                                            </p>
                                                                            <p class="mt-1 text-sm text-slate-700"
                                                                                x-text="registro.frecuencia"></p>
                                                                        </div>
                                                                    </template>

                                                                    <template x-if="registro.duracion">
                                                                        <div>
                                                                            <p class="text-xs font-medium text-slate-500">
                                                                                Duración
                                                                            </p>
                                                                            <p class="mt-1 text-sm text-slate-700"
                                                                                x-text="registro.duracion"></p>
                                                                        </div>
                                                                    </template>

                                                                </div>

                                                                <template x-if="registro.procedimiento">
                                                                    <div class="mt-3">
                                                                        <p class="text-xs font-medium text-slate-500">
                                                                            Procedimiento
                                                                        </p>
                                                                        <p class="mt-1 whitespace-pre-line break-words
                                                                            text-sm text-slate-700"
                                                                            x-text="registro.procedimiento"></p>
                                                                    </div>
                                                                </template>

                                                                <template x-if="registro.examenOrdenado">
                                                                    <div class="mt-3">
                                                                        <p class="text-xs font-medium text-slate-500">
                                                                            Exámenes ordenados
                                                                        </p>
                                                                        <p class="mt-1 whitespace-pre-line break-words
                                                                            text-sm text-slate-700"
                                                                            x-text="registro.examenOrdenado"></p>
                                                                    </div>
                                                                </template>

                                                                <template x-if="registro.indicaciones">
                                                                    <div class="mt-3">
                                                                        <p class="text-xs font-medium text-slate-500">
                                                                            Indicaciones
                                                                        </p>
                                                                        <p class="mt-1 whitespace-pre-line break-words
                                                                            text-sm text-slate-700"
                                                                            x-text="registro.indicaciones"></p>
                                                                    </div>
                                                                </template>

                                                            </div>

                                                        </template>

                                                    </div>

                                                </template>

                                                <p x-show="!evolucion.diagnostico_tratamiento ||
                                                    evolucion.diagnostico_tratamiento.length === 0"
                                                    class="rounded-lg bg-slate-50 p-3 text-sm text-slate-500">
                                                    No hay diagnósticos ni tratamientos registrados para esta evolución.
                                                </p>

                                            </div>

                                        </div>

                                    </div>

                                </template>

                            </div>

                        </template>

                        <p x-show="!historia.evoluciones || historia.evoluciones.length === 0"
                            class="rounded-xl bg-slate-50 p-4 text-sm text-slate-500">
                            Esta historia clínica todavía no tiene evoluciones registradas.
                        </p>

                    </div>

                </div>

                {{-- Pie del modal --}}
                <div class="flex justify-end border-t border-slate-100
                            bg-slate-50/70 px-6 py-4">

                    <button type="button"
                        @click="mostrarModal = false"
                        class="inline-flex items-center justify-center rounded-lg
                            border border-slate-300 bg-white px-5 py-2.5
                            text-sm font-semibold text-slate-700
                            transition hover:bg-slate-100">

                        Cerrar

                    </button>

                </div>

            </div>

        </div>

    </div>

@endsection


