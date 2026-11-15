@extends('layouts.app')

@section('title', 'Gemas')
@section('page-title', '')

@section('content')

    <div class="w-full min-w-0 space-y-6">

        {{-- Encabezado --}}
        <div class="flex flex-wrap items-center justify-between gap-3">
            <div>
                <h1 class="text-xl sm:text-2xl font-bold text-slate-800">
                    ¡Bienvenido, {{ $usuarioActual->nombre ?? 'Usuario' }}!
                </h1>
                <p class="mt-1 text-sm text-slate-500">
                    Consulta la información de tus mascotas y sus servicios veterinarios.
                </p>
            </div>

            <div class="hidden sm:flex items-center gap-2 rounded-xl bg-white border border-slate-200 px-4 py-2 shadow-sm">
                <span class="text-sm text-slate-500">Fecha:</span>
                <span class="text-sm font-semibold text-slate-700">
                    {{ now()->format('d/m/Y') }}
                </span>
            </div>
        </div>

        {{-- Estadísticas --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-3 gap-4">

            <x-stat-card
                label="Mis mascotas"
                :value="number_format($totalMascotas)"
                icon="mascota"
            />

            <x-stat-card
                label="Próximas citas"
                :value="number_format($totalProximasCitas)"
                icon="cita"
            />

            <x-stat-card
                label="Servicios recibidos"
                :value="number_format($totalServiciosRecibidos)"
                icon="servicio"
            />

        </div>

        

        {{-- Accesos rápidos y próximas citas --}}
        <div class="grid grid-cols-1 xl:grid-cols-2 gap-5">

            {{-- Accesos rápidos --}}
            <section class="bg-white rounded-xl border border-slate-200 shadow-sm overflow-hidden">

                <div class="px-5 py-4 border-b border-slate-200">
                    <h2 class="font-semibold text-slate-800">Accesos rápidos</h2>
                    <p class="text-xs text-slate-500 mt-1">
                        Encuentra fácilmente los servicios de GEMAS.
                    </p>
                </div>

                <div class="p-5 grid grid-cols-1 sm:grid-cols-2 gap-4">

                    {{-- Agendar cita --}}
                    <a href="{{ route('cita.create') }}"
                    class="flex items-center gap-3 p-4 rounded-xl border border-slate-200 bg-slate-50 hover:bg-primary-50 hover:border-primary-200 transition">

                        <div class="w-11 h-11 shrink-0 rounded-xl bg-blue-100 text-blue-700 flex items-center justify-center">
                            @include('layouts.partials.icons', ['icon' => 'cita'])
                        </div>

                        <div>
                            <p class="text-sm font-semibold text-slate-800">Agendar cita</p>
                            <p class="text-xs text-slate-500 mt-1">Solicitar atención</p>
                        </div>
                    </a>

                    {{-- Horarios --}}
                    <a href="{{ route('horario.index') }}"
                    class="flex items-center gap-3 p-4 rounded-xl border border-slate-200 bg-slate-50 hover:bg-primary-50 hover:border-primary-200 transition">

                        <div class="w-11 h-11 shrink-0 rounded-xl bg-violet-100 text-violet-700 flex items-center justify-center">
                            @include('layouts.partials.icons', ['icon' => 'horario'])
                        </div>

                        <div>
                            <p class="text-sm font-semibold text-slate-800">Horarios</p>
                            <p class="text-xs text-slate-500 mt-1">Consultar disponibilidad</p>
                        </div>
                    </a>

                    {{-- Servicios --}}
                    <a href="{{ route('servicio.index') }}"
                    class="flex items-center gap-3 p-4 rounded-xl border border-slate-200 bg-slate-50 hover:bg-primary-50 hover:border-primary-200 transition">

                        <div class="w-11 h-11 shrink-0 rounded-xl bg-amber-100 text-amber-700 flex items-center justify-center">
                            @include('layouts.partials.icons', ['icon' => 'servicio'])
                        </div>

                        <div>
                            <p class="text-sm font-semibold text-slate-800">Servicios</p>
                            <p class="text-xs text-slate-500 mt-1">Conocer los servicios</p>
                        </div>
                    </a>

                    {{-- Historias clínicas --}}
                    <a href="{{ route('historiaclinica.index') }}"
                    class="flex items-center gap-3 p-4 rounded-xl border border-slate-200 bg-slate-50 hover:bg-primary-50 hover:border-primary-200 transition">

                        <div class="w-11 h-11 shrink-0 rounded-xl bg-emerald-100 text-emerald-700 flex items-center justify-center">
                            @include('layouts.partials.icons', ['icon' => 'historiaclinica'])
                        </div>

                        <div>
                            <p class="text-sm font-semibold text-slate-800">Historias clínicas</p>
                            <p class="text-xs text-slate-500 mt-1">Consultar historiales</p>
                        </div>
                    </a>

                </div>
            </section>

            {{-- Mis mascotas --}}
            <section
                class="bg-white rounded-xl border border-slate-200 shadow-sm overflow-hidden"
                x-data="{
                    mostrarPerfil: false,
                    mascotaSeleccionada: {},

                    abrirPerfil(mascota) {
                        this.mascotaSeleccionada = mascota;
                        this.mostrarPerfil = true;
                    }
                }">
                
                {{-- Encabezado --}}
                <div class="px-5 py-4 border-b border-slate-200 flex items-center justify-between gap-3">

                    <div>
                        <h2 class="font-semibold text-slate-800">Mis mascotas</h2>
                        <p class="text-xs text-slate-500 mt-1">
                            Consulta los perfiles de tus mascotas registradas.
                        </p>
                    </div>

                    <a href="{{ route('mascota.index') }}"
                        class="text-sm font-medium text-primary-700 hover:text-primary-900 whitespace-nowrap">
                        Ver todas →
                    </a>

                </div>

                {{-- Listado --}}
                <div class="p-5">

                    @forelse($mascotas as $mascota)

                        <div class="flex flex-col sm:flex-row sm:items-center gap-4
                                    p-4 rounded-xl border border-slate-200
                                    hover:border-primary-200 hover:bg-slate-50
                                    transition mb-3 last:mb-0">

                            {{-- Imagen --}}
                            <div class="w-20 h-20 shrink-0 rounded-xl overflow-hidden
                                        bg-slate-100 flex items-center justify-center">

                                @if($mascota->imagen && file_exists(public_path('storage/' . $mascota->imagen)))

                                    <img
                                        src="{{ asset('storage/' . $mascota->imagen) }}"
                                        alt="{{ $mascota->nombre }}"
                                        class="w-full h-full object-cover"
                                    >

                                @else

                                    @include('layouts.partials.icons', ['icon' => 'mascota'])

                                @endif

                            </div>

                            {{-- Información --}}
                            <div class="flex-1 min-w-0">

                                <h3 class="font-semibold text-slate-800">
                                    {{ $mascota->nombre }}
                                </h3>

                                <p class="text-sm text-slate-500 mt-1">
                                    {{ $mascota->especie }}
                                    @if($mascota->raza)
                                        · {{ $mascota->raza }}
                                    @endif
                                </p>

                            </div>

                            {{-- Ver perfil --}}
                            <button
                                type="button"
                                @click="abrirPerfil({
                                    id: @js($mascota->id),
                                    nombre: @js($mascota->nombre),
                                    imagen: @js($mascota->imagen ? asset('storage/' . $mascota->imagen) : null),
                                    especie: @js($mascota->especie),
                                    raza: @js($mascota->raza),
                                    sexo: @js($mascota->sexo),
                                    fechaNacimiento: @js($mascota->fechaNacimiento),
                                    color: @js($mascota->color),
                                    peso: @js($mascota->peso)
                                })"
                                class="inline-flex items-center justify-center gap-2
                                    px-4 py-2 rounded-lg bg-primary-50
                                    text-primary-700 text-sm font-medium
                                    hover:bg-primary-100 transition">

                                Ver perfil
                                <span>→</span>

                            </button>

                        </div>

                    @empty

                        <div class="py-10 text-center">

                            <div class="mx-auto w-12 h-12 rounded-full bg-primary-50
                                        text-primary-600 flex items-center justify-center mb-3">

                                @include('layouts.partials.icons', ['icon' => 'mascota'])

                            </div>

                            <p class="text-sm font-medium text-slate-600">
                                Todavía no tienes mascotas registradas.
                            </p>

                            <a href="{{ route('mascota.create') }}"
                                class="inline-block mt-3 text-sm font-medium
                                    text-primary-700 hover:text-primary-900">
                                Registrar mi mascota →
                            </a>

                        </div>

                    @endforelse

                </div>

                {{-- Modal: Perfil de mascota --}}
                <div
                    x-cloak
                    x-show="mostrarPerfil"
                    x-transition.opacity
                    @keydown.escape.window="mostrarPerfil = false"
                    @click.self="mostrarPerfil = false"
                    class="fixed inset-0 z-50 flex items-center justify-center
                        bg-slate-900/50 p-4"
                >

                    <div
                        x-show="mostrarPerfil"
                        x-transition
                        class="flex max-h-[90vh] w-full max-w-2xl flex-col
                            overflow-hidden rounded-2xl bg-white shadow-xl"
                    >

                        {{-- Encabezado --}}
                        <div class="flex items-center justify-between gap-4
                                    border-b border-slate-100 px-6 py-5">

                            <div>
                                <h2 class="text-lg font-bold text-slate-800">
                                    Perfil de mascota
                                </h2>

                                <p class="mt-1 text-sm text-slate-500">
                                    Información general de tu mascota.
                                </p>
                            </div>

                            <button
                                type="button"
                                @click="mostrarPerfil = false"
                                class="flex h-9 w-9 items-center justify-center
                                    rounded-lg text-slate-500 hover:bg-slate-100 transition"
                                title="Cerrar"
                            >
                                <svg class="h-5 w-5" fill="none"
                                    stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round"
                                        stroke-linejoin="round" stroke-width="2"
                                        d="M6 18 18 6M6 6l12 12"/>
                                </svg>
                            </button>

                        </div>

                        {{-- Contenido --}}
                        <div class="flex-1 overflow-y-auto px-6 py-6 space-y-6">

                            {{-- Presentación --}}
                            <div class="flex flex-col sm:flex-row items-center gap-5">

                                <div class="h-28 w-28 shrink-0 overflow-hidden
                                            rounded-2xl bg-[#EAF4F5]
                                            flex items-center justify-center">

                                    <template x-if="mascotaSeleccionada.imagen">

                                        <img
                                            :src="mascotaSeleccionada.imagen"
                                            :alt="mascotaSeleccionada.nombre"
                                            class="h-full w-full object-cover"
                                        >

                                    </template>

                                    <template x-if="!mascotaSeleccionada.imagen">

                                        <div class="text-[#40899A]">
                                            @include('layouts.partials.icons', ['icon' => 'mascota'])
                                        </div>

                                    </template>

                                </div>

                                <div class="text-center sm:text-left">

                                    <h3 class="text-xl font-bold text-slate-800"
                                        x-text="mascotaSeleccionada.nombre">
                                    </h3>

                                    <p class="mt-1 text-sm text-slate-500"
                                        x-text="mascotaSeleccionada.especie +
                                            (mascotaSeleccionada.raza
                                                ? ' · ' + mascotaSeleccionada.raza
                                                : '')">
                                    </p>

                                    <span class="inline-flex mt-3 rounded-full
                                                bg-[#EAF4F5] px-3 py-1
                                                text-xs font-semibold text-[#40899A]">
                                        Mascota registrada
                                    </span>

                                </div>

                            </div>

                            {{-- Datos generales --}}
                            <div>

                                <h3 class="mb-4 text-sm font-semibold text-slate-800">
                                    Información general
                                </h3>

                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">

                                    <div class="rounded-xl bg-slate-50 p-4">
                                        <p class="text-xs font-medium text-slate-500">
                                            Especie
                                        </p>
                                        <p class="mt-1 text-sm font-semibold text-slate-800"
                                            x-text="mascotaSeleccionada.especie || 'No registrada'">
                                        </p>
                                    </div>

                                    <div class="rounded-xl bg-slate-50 p-4">
                                        <p class="text-xs font-medium text-slate-500">
                                            Raza
                                        </p>
                                        <p class="mt-1 text-sm font-semibold text-slate-800"
                                            x-text="mascotaSeleccionada.raza || 'No registrada'">
                                        </p>
                                    </div>

                                    <div class="rounded-xl bg-slate-50 p-4">
                                        <p class="text-xs font-medium text-slate-500">
                                            Sexo
                                        </p>
                                        <p class="mt-1 text-sm font-semibold text-slate-800"
                                            x-text="mascotaSeleccionada.sexo || 'No registrado'">
                                        </p>
                                    </div>

                                    <div class="rounded-xl bg-slate-50 p-4">
                                        <p class="text-xs font-medium text-slate-500">
                                            Fecha de nacimiento
                                        </p>
                                        <p class="mt-1 text-sm font-semibold text-slate-800"
                                            x-text="mascotaSeleccionada.fechaNacimiento
                                                ? mascotaSeleccionada.fechaNacimiento.split('-').reverse().join('/')
                                                : 'No registrada'">
                                        </p>
                                    </div>

                                    <div class="rounded-xl bg-slate-50 p-4">
                                        <p class="text-xs font-medium text-slate-500">
                                            Color
                                        </p>
                                        <p class="mt-1 text-sm font-semibold text-slate-800"
                                            x-text="mascotaSeleccionada.color || 'No registrado'">
                                        </p>
                                    </div>

                                    <div class="rounded-xl bg-slate-50 p-4">
                                        <p class="text-xs font-medium text-slate-500">
                                            Peso
                                        </p>
                                        <p class="mt-1 text-sm font-semibold text-slate-800"
                                            x-text="mascotaSeleccionada.peso
                                                ? mascotaSeleccionada.peso + ' kg'
                                                : 'No registrado'">
                                        </p>
                                    </div>

                                </div>

                            </div>

                            {{-- Acceso a historia clínica --}}
                            <div class="rounded-xl border border-[#d5ebed]
                                        bg-[#EAF4F5] p-4">

                                <div class="flex flex-col sm:flex-row
                                            sm:items-center sm:justify-between gap-3">

                                    <div>
                                        <h3 class="text-sm font-semibold text-slate-800">
                                            Historia clínica
                                        </h3>

                                        <p class="mt-1 text-xs text-slate-600">
                                            Consulta la información médica y las evoluciones de tu mascota.
                                        </p>
                                    </div>

                                    <a
                                        :href="'{{ route('historiaclinica.index') }}?idMascota=' + mascotaSeleccionada.id"
                                        class="inline-flex items-center justify-center gap-2
                                            rounded-lg bg-[#40899A] px-4 py-2.5
                                            text-sm font-semibold text-white
                                            transition hover:bg-[#347787]">

                                        Consultar historia
                                        <span>→</span>

                                    </a>

                                </div>

                            </div>

                        </div>

                        {{-- Pie --}}
                        <div class="flex justify-end border-t border-slate-100
                                    bg-slate-50/70 px-6 py-4">

                            <button
                                type="button"
                                @click="mostrarPerfil = false"
                                class="rounded-lg border border-slate-300 bg-white
                                    px-5 py-2.5 text-sm font-semibold
                                    text-slate-700 transition hover:bg-slate-100">

                                Cerrar

                            </button>

                        </div>

                    </div>

                </div>

            </section>

        </div>


    </div>

@endsection
