@extends('layouts.app')

@section('title', 'Mascotas en adopción - GEMAS')

@section('content')
      
    <div class="w-full max-w-7xl mx-auto space-y-6"
        x-data="{
            mostrarModal: false,
            mascota: {},

            abrirMascota(datos) {
                this.mascota = datos;
                this.mostrarModal = true;
            },

            cerrarModal() {
                this.mostrarModal = false;
                this.mascota = {};
            }
        }">

        {{-- ENCABEZADO --}}
        <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <h2 class="text-2xl font-bold text-slate-800">
                    Mascotas en adopción
                </h2>
                <p class="mt-1 text-sm text-slate-500">
                    Administra la información de las mascotas disponibles para adopción.
                </p>
            </div>

            <a href="{{ route('mascotasAdopcion.create') }}"
                class="inline-flex items-center justify-center gap-2 rounded-lg bg-[#40899A] px-4 py-2.5 text-sm font-semibold text-white transition hover:bg-[#347889]">
                    <svg class="h-5 w-5" fill="none" stroke="currentColor"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            stroke-width="2" d="M12 4v16m8-8H4"/>
                    </svg>
                Registrar mascota
            </a>
        </div>

        {{-- MENSAJES --}}
        @if (session('success'))
            <div class="rounded-lg border border-green-200 bg-green-50 px-4 py-3 text-sm text-green-700">
                <i class="fa-solid fa-circle-check mr-2"></i>
                {{ session('success') }}
            </div>
        @endif

        @if (session('error'))
            <div class="rounded-lg border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-700">
                <i class="fa-solid fa-circle-exclamation mr-2"></i>
                {{ session('error') }}
            </div>
        @endif

        {{-- TABLA --}}
        <div class="overflow-hidden rounded-xl border border-slate-200 bg-white shadow-sm">

            <div class="overflow-x-auto">
                <table class="w-full min-w-[850px] text-left text-sm text-slate-600">

                    <thead class="bg-slate-50 text-slate-500">
                        <tr>
                            <th class="px-6 py-3 font-medium">#</th>
                            <th class="px-6 py-3 font-medium">Mascota</th>
                            <th class="px-6 py-3 font-medium">Especie</th>
                            <th class="px-6 py-3 font-medium">Raza</th>
                            <th class="px-6 py-3 font-medium">Sexo</th>
                            <th class="px-6 py-3 font-medium">Estado</th>
                            <th class="px-6 py-3 font-medium text-center">
                                Acciones
                            </th>
                        </tr>
                    </thead>

                    <tbody class="divide-y divide-slate-100">

                        @forelse ($mascotas as $mascota)
                            <tr class="transition hover:bg-slate-50">

                                <td class="px-6 py-4 text-slate-500">
                                    {{ $mascota->id }}
                                </td>

                                {{-- MASCOTA --}}
                                <td class="whitespace-nowrap px-6 py-4">
                                    <div class="flex items-center gap-3">
                                        @if ($mascota->imagen)
                                            <img src="{{ asset('storage/' . $mascota->imagen) }}"
                                                alt="{{ $mascota->nombre }}"
                                                class="h-10 w-10 rounded-full object-cover">
                                        @else
                                            <div class="flex h-10 w-10 items-center justify-center rounded-full bg-[#EAF4F5] text-[#40899A]">
                                                <i class="fa-solid fa-paw"></i>
                                            </div>
                                        @endif

                                        <span class="font-semibold text-slate-800">
                                            {{ $mascota->nombre }}
                                        </span>
                                    </div>
                                </td>

                                {{-- ESPECIE --}}
                                <td class="px-6 py-4">
                                    {{ $mascota->especie }}
                                </td>

                                {{-- RAZA --}}
                                <td class="px-6 py-4">
                                    {{ $mascota->raza ?: 'No registrada' }}
                                </td>

                                {{-- SEXO --}}
                                <td class="px-6 py-4">
                                    {{ $mascota->sexo }}
                                </td>

                                {{-- ESTADO --}}
                                <td class="px-6 py-4">
                                    @if ($mascota->estado === 'En adopción')
                                        <span class="rounded-full bg-green-100 px-3 py-1 text-xs font-medium text-green-700">
                                            En adopción
                                        </span>
                                    @else
                                        <span class="rounded-full bg-slate-100 px-3 py-1 text-xs font-medium text-slate-600">
                                            {{ $mascota->estado }}
                                        </span>
                                    @endif
                                </td>

                                {{-- ACCIONES --}}
                                <td class="px-6 py-4">
                                    <div class="flex items-center justify-center gap-2">

                                        {{-- VER --}}
                                        <button type="button"
                                            @click="abrirMascota({
                                                nombre: @js($mascota->nombre),
                                                especie: @js($mascota->especie),
                                                raza: @js($mascota->raza ?: 'No registrada'),
                                                sexo: @js($mascota->sexo),
                                                fechaNacimiento: @js($mascota->fechaNacimiento ? \Carbon\Carbon::parse($mascota->fechaNacimiento)->format('d/m/Y') : 'No registrada'),
                                                peso: @js($mascota->peso),
                                                color: @js($mascota->color ?: 'No registrado'),
                                                estado: @js($mascota->estado),
                                                descripcion: @js($mascota->descripcion ?: 'Sin descripción registrada'),
                                                imagen: @js($mascota->imagen ? asset('storage/' . $mascota->imagen) : null)
                                            })"
                                            title="Ver información"
                                            class="flex h-9 w-9 shrink-0 items-center justify-center rounded-lg
                                                bg-[#EAF4F5] text-[#40899A]
                                                transition hover:bg-[#DCEEF2] hover:text-[#306174]">

                                            <svg class="h-5 w-5" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    stroke-width="1.8"
                                                    d="M2.25 12s3.5-7 9.75-7 9.75 7
                                                    9.75 7-3.5 7-9.75 7-9.75-7-9.75-7Z"/>
                                                <circle cx="12" cy="12" r="3"
                                                    stroke-width="1.8"/>
                                            </svg>
                                        </button>

                                        {{-- EDITAR --}}
                                        <a href="{{ route('mascotasAdopcion.edit', $mascota->id) }}"
                                            title="Editar"
                                            class="flex h-9 w-9 shrink-0 items-center justify-center rounded-lg
                                                bg-amber-50 text-amber-600
                                                transition hover:bg-amber-100 hover:text-amber-700">

                                            <svg class="h-5 w-5" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    stroke-width="1.8"
                                                    d="m16 4 4 4M4 20l4-1 12-12a2.8 2.8 0 0 0-4-4L4 15l-1 5z"/>
                                            </svg>
                                        </a>

                                    </div>
                                </td>

                            </tr>
                        @empty
                            {{-- Sin mascotas --}}
                            <tr>
                                <td colspan="{{ auth()->user()->hasRole('administrador') ? 7 : 6 }}"
                                    class="px-6 py-12 text-center">

                                    <div class="mx-auto flex h-14 w-14 items-center justify-center
                                                rounded-full bg-[#EAF4F5] text-[#40899A]">

                                        @include('layouts.partials.icons', ['icon' => 'adopcion'])

                                    </div>

                                    <h3 class="mt-4 text-base font-semibold text-slate-800">
                                        No hay mascotas en adopcion registradas
                                    </h3>

                                    <p class="mt-1 text-sm text-slate-500">
                                        Cuando registres una mascota, aparecerá aquí.
                                    </p>

                                    <a href="{{ route('mascotasAdopcion.create') }}"
                                        class="inline-flex items-center gap-2 mt-4
                                            rounded-lg bg-primary-600 px-4 py-2.5
                                            text-sm font-semibold text-white
                                            hover:bg-primary-700 transition">

                                        Registrar primera mascota

                                    </a>

                                </td>
                            </tr>
                        @endforelse

                    </tbody>
                </table>
            </div>

            {{-- PAGINACIÓN --}}
            @if ($mascotas->hasPages())
                <div class="border-t border-slate-200 px-6 py-4">
                    {{ $mascotas->links() }}
                </div>
            @endif

        </div>
 
    {{-- MODAL: INFORMACIÓN DE LA MASCOTA --}}
    <div
        x-cloak
        x-show="mostrarModal"
        x-transition.opacity
        @keydown.escape.window="cerrarModal()"
        @click.self="cerrarModal()"
        class="fixed inset-0 z-50 flex items-center justify-center bg-slate-900/50 p-4">

        <div
            x-show="mostrarModal"
            x-transition
            class="flex max-h-[90vh] w-full max-w-2xl flex-col overflow-hidden rounded-2xl bg-white shadow-xl">

            {{-- ENCABEZADO --}}
            <div class="flex items-center justify-between gap-4 border-b border-slate-100 px-6 py-5">

                <div class="flex items-center gap-3">

                    <div class="flex h-11 w-11 shrink-0 items-center justify-center rounded-xl bg-[#EAF4F5] text-[#40899A]">
                        @include('layouts.partials.icons', [
                                'icon' => 'adopcion'
                            ])
                    </div>

                    <div>
                        <h2 class="text-lg font-bold text-slate-800">
                            Información de la mascota
                        </h2>

                        <p class="mt-1 text-sm text-slate-500">
                            Datos generales de la mascota registrada para adopción.
                        </p>
                    </div>

                </div>

                <button type="button"
                    @click="cerrarModal()"
                    class="flex h-9 w-9 shrink-0 items-center justify-center rounded-lg text-slate-500 transition hover:bg-slate-100"
                    title="Cerrar">

                    <i class="fa-solid fa-xmark text-lg"></i>

                </button>

            </div>

            {{-- CONTENIDO DESPLAZABLE --}}
            <div class="flex-1 space-y-6 overflow-y-auto px-6 py-5">

                {{-- INFORMACIÓN GENERAL --}}
                <div>

                    <div class="mb-4 flex items-center justify-between gap-3">

                        <h3 class="text-sm font-semibold text-slate-800">
                            Información general
                        </h3>

                        <span
                            class="rounded-full px-3 py-1 text-xs font-semibold"
                            :class="mascota.estado === 'En adopción'
                                ? 'bg-green-50 text-green-700'
                                : mascota.estado === 'Adoptada'
                                    ? 'bg-blue-50 text-blue-700'
                                    : 'bg-slate-100 text-slate-600'"
                            x-text="mascota.estado">
                        </span>

                    </div>

                    {{-- FOTOGRAFÍA --}}
                    <div class="mb-5 flex flex-col items-center rounded-xl bg-slate-50 p-5">

                        <template x-if="mascota.imagen">
                            <img :src="mascota.imagen"
                                :alt="mascota.nombre"
                                class="h-36 w-36 rounded-xl border border-slate-200 bg-white object-cover shadow-sm">
                        </template>

                        <template x-if="!mascota.imagen">
                            <div class="flex h-36 w-36 items-center justify-center rounded-xl bg-[#EAF4F5] text-[#40899A]">
                                <i class="fa-solid fa-paw text-5xl"></i>
                            </div>
                        </template>

                        <h3 class="mt-3 text-lg font-bold text-slate-800"
                            x-text="mascota.nombre">
                        </h3>

                        <p class="mt-1 text-sm text-slate-500"
                            x-text="mascota.especie + ' · ' + mascota.raza">
                        </p>

                    </div>

                    {{-- DATOS --}}
                    <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">

                        <div class="rounded-xl bg-slate-50 p-4">
                            <p class="text-xs font-medium text-slate-500">
                                Nombre
                            </p>
                            <p class="mt-1 font-semibold text-slate-800"
                                x-text="mascota.nombre">
                            </p>
                        </div>

                        <div class="rounded-xl bg-slate-50 p-4">
                            <p class="text-xs font-medium text-slate-500">
                                Especie
                            </p>
                            <p class="mt-1 font-semibold text-slate-800"
                                x-text="mascota.especie">
                            </p>
                        </div>

                        <div class="rounded-xl bg-slate-50 p-4">
                            <p class="text-xs font-medium text-slate-500">
                                Raza
                            </p>
                            <p class="mt-1 font-semibold text-slate-800"
                                x-text="mascota.raza">
                            </p>
                        </div>

                        <div class="rounded-xl bg-slate-50 p-4">
                            <p class="text-xs font-medium text-slate-500">
                                Sexo
                            </p>
                            <p class="mt-1 font-semibold text-slate-800"
                                x-text="mascota.sexo">
                            </p>
                        </div>

                        <div class="rounded-xl bg-slate-50 p-4">
                            <p class="text-xs font-medium text-slate-500">
                                Fecha de nacimiento
                            </p>
                            <p class="mt-1 font-semibold text-slate-800"
                                x-text="mascota.fechaNacimiento">
                            </p>
                        </div>

                        <div class="rounded-xl bg-slate-50 p-4">
                            <p class="text-xs font-medium text-slate-500">
                                Peso
                            </p>
                            <p class="mt-1 font-semibold text-slate-800">
                                <span x-text="mascota.peso !== null && mascota.peso !== '' ? Number(mascota.peso).toFixed(2) : 'No registrado'"></span>
                                <span x-show="mascota.peso !== null && mascota.peso !== ''"> kg</span>
                            </p>
                        </div>

                        <div class="rounded-xl bg-slate-50 p-4 sm:col-span-2">
                            <p class="text-xs font-medium text-slate-500">
                                Color
                            </p>
                            <p class="mt-1 font-semibold text-slate-800"
                                x-text="mascota.color">
                            </p>
                        </div>

                    </div>

                </div>

                {{-- DESCRIPCIÓN --}}
                <div class="border-t border-slate-100 pt-5">

                    <div class="mb-4">
                        <h3 class="text-sm font-semibold text-slate-800">
                            Descripción
                        </h3>

                        <p class="mt-1 text-xs text-slate-500">
                            Información adicional sobre la mascota.
                        </p>
                    </div>

                    <div class="rounded-xl bg-slate-50 p-4">

                        <p class="whitespace-pre-line break-words text-sm leading-relaxed text-slate-600"
                            x-text="mascota.descripcion || 'Sin descripción registrada.'">
                        </p>

                    </div>

                </div>

            </div>

            {{-- PIE DEL MODAL --}}
            <div class="flex justify-end border-t border-slate-100 bg-slate-50/70 px-6 py-4">

                <button type="button"
                    @click="cerrarModal()"
                    class="inline-flex items-center justify-center rounded-lg border border-slate-300 bg-white px-5 py-2.5 text-sm font-semibold text-slate-700 transition hover:bg-slate-100">

                    Cerrar

                </button>

            </div>

        </div>

    </div>

    </div>

@endsection
