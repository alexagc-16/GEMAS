@extends('layouts.app')

@section('title', 'Mascotas en adopción - GEMAS')

@section('content')

<div class="w-full max-w-7xl mx-auto space-y-6">

    {{-- ENCABEZADO --}}
    <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
        <div>
            <h2 class="text-2xl font-bold text-slate-800">
                Mascotas en adopción
            </h2>
            <p class="text-sm text-slate-500 mt-1">
                Administra las mascotas disponibles para encontrar un nuevo hogar.
            </p>
        </div>

        <a href="{{ route('mascotasAdopcion.create') }}"
            class="inline-flex items-center justify-center gap-2 px-5 py-3
                   bg-[#40899A] hover:bg-[#347889] text-white
                   rounded-xl text-sm font-semibold transition shadow-sm">

            <svg class="w-5 h-5" fill="none" stroke="currentColor"
                viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round"
                    stroke-width="2" d="M12 5v14m7-7H5"/>
            </svg>

            Registrar mascota
        </a>
    </div>

    {{-- MENSAJES --}}
    @if (session('success'))
        <div class="flex items-center gap-3 p-4 rounded-xl
                    bg-emerald-50 border border-emerald-200 text-emerald-700">
            <svg class="w-5 h-5 flex-shrink-0" fill="none"
                stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round"
                    stroke-width="2" d="M5 13l4 4L19 7"/>
            </svg>
            <p class="text-sm font-medium">{{ session('success') }}</p>
        </div>
    @endif

    @if (session('error'))
        <div class="p-4 rounded-xl bg-red-50 border border-red-200 text-red-700">
            <p class="text-sm font-medium">{{ session('error') }}</p>
        </div>
    @endif

    {{-- CONTADOR --}}
    <div class="bg-white border border-slate-200 rounded-2xl p-5 shadow-sm">
        <div class="flex items-center gap-4">
            <div class="w-12 h-12 rounded-xl bg-[#EAF4F5]
                        flex items-center justify-center">
                <svg class="w-6 h-6 text-[#40899A]" fill="none"
                    stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        stroke-width="1.8"
                        d="M12 12c2.5 0 4-2 4-4s-1.5-4-4-4-4 2-4 4 1.5 4 4 4zm-7 8c0-3.3 3.1-5 7-5s7 1.7 7 5"/>
                </svg>
            </div>

            <div>
                <p class="text-sm text-slate-500">Total de mascotas registradas</p>
                <p class="text-2xl font-bold text-slate-800">
                    {{ $mascotas->total() ?? $mascotas->count() }}
                </p>
            </div>
        </div>
    </div>

    {{-- TARJETAS --}}
    @if ($mascotas->count() > 0)

        <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-3 gap-6">

            @foreach ($mascotas as $mascota)

                <article class="bg-white rounded-2xl overflow-hidden
                                border border-slate-200 shadow-sm
                                hover:shadow-md transition duration-300">

                    {{-- IMAGEN --}}
                    <div class="relative h-64 bg-[#EAF4F5] overflow-hidden">

                        @if ($mascota->imagen)
                            <img src="{{ asset('storage/' . $mascota->imagen) }}"
                                alt="{{ $mascota->nombre }}"
                                class="w-full h-full object-contain p-3">
                        @else
                            <div class="w-full h-full flex flex-col
                                        items-center justify-center text-slate-400">
                                <svg class="w-16 h-16" fill="none"
                                    stroke="currentColor" viewBox="0 0 24 24">
                                    <rect x="3" y="3" width="18" height="18"
                                        rx="2" stroke-width="1.5"/>
                                    <circle cx="8.5" cy="8.5" r="1.5"/>
                                    <path stroke-width="1.5"
                                        d="m21 15-5-5L5 21"/>
                                </svg>
                                <span class="text-xs mt-2">Sin fotografía</span>
                            </div>
                        @endif

                        {{-- ESTADO --}}
                        <span class="absolute top-4 left-4 px-3 py-1.5
                            rounded-full text-xs font-bold
                            @if ($mascota->estado === 'En adopción')
                                bg-emerald-100 text-emerald-700
                            @elseif ($mascota->estado === 'Adoptada')
                                bg-blue-100 text-blue-700
                            @else
                                bg-slate-200 text-slate-700
                            @endif">
                            {{ $mascota->estado }}
                        </span>
                    </div>

                    {{-- INFORMACIÓN --}}
                    <div class="p-5">

                        <div class="flex items-start justify-between gap-3 mb-3">
                            <div>
                                <h3 class="text-xl font-bold text-slate-800">
                                    {{ $mascota->nombre }}
                                </h3>

                                <p class="text-sm text-[#40899A] font-semibold mt-1">
                                    {{ $mascota->especie }}
                                    @if ($mascota->raza)
                                        · {{ $mascota->raza }}
                                    @endif
                                </p>
                            </div>

                            <span class="text-xs font-semibold px-3 py-1.5
                                rounded-full bg-[#EAF4F5] text-[#347889]">
                                {{ $mascota->sexo }}
                            </span>
                        </div>

                        <p class="text-sm text-slate-500 leading-relaxed mb-4
                                  min-h-[40px]">
                            {{ $mascota->descripcion ?: 'Sin descripción registrada.' }}
                        </p>

                        <div class="grid grid-cols-2 gap-3 border-t
                                    border-slate-100 pt-4">

                            <div>
                                <p class="text-xs text-slate-400">Nacimiento</p>
                                <p class="text-sm font-medium text-slate-700 mt-1">
                                    {{ $mascota->fechaNacimiento
                                        ? \Carbon\Carbon::parse($mascota->fechaNacimiento)->format('d/m/Y')
                                        : 'No registrado' }}
                                </p>
                            </div>

                            <div>
                                <p class="text-xs text-slate-400">Peso</p>
                                <p class="text-sm font-medium text-slate-700 mt-1">
                                    {{ $mascota->peso !== null
                                        ? number_format((float) $mascota->peso, 2) . ' kg'
                                        : 'No registrado' }}
                                </p>
                            </div>

                            <div>
                                <p class="text-xs text-slate-400">Color</p>
                                <p class="text-sm font-medium text-slate-700 mt-1">
                                    {{ $mascota->color ?: 'No registrado' }}
                                </p>
                            </div>
                        </div>

                        {{-- ACCIONES --}}
                        <div class="flex items-center gap-3 mt-5 pt-4
                                    border-t border-slate-100">

                            <a href="{{ route('mascotasAdopcion.edit', $mascota) }}"
                                class="flex-1 inline-flex items-center justify-center
                                       gap-2 py-2.5 rounded-lg bg-[#EAF4F5]
                                       text-[#347889] hover:bg-[#DCEEF2]
                                       text-sm font-semibold transition">

                                <svg class="w-4 h-4" fill="none"
                                    stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round"
                                        stroke-linejoin="round" stroke-width="2"
                                        d="m16 4 4 4M4 20l4-1 12-12a2.8 2.8 0 0 0-4-4L4 15l-1 5z"/>
                                </svg>

                                Editar
                            </a>

                            <form action="{{ route('mascotasAdopcion.destroy', $mascota) }}"
                                method="POST"
                                onsubmit="return confirm('¿Estás seguro de eliminar esta mascota?')">
                                @csrf
                                @method('DELETE')

                                <button type="submit"
                                    class="inline-flex items-center justify-center
                                           w-10 h-10 rounded-lg bg-red-50
                                           text-red-600 hover:bg-red-100 transition"
                                    title="Eliminar mascota">

                                    <svg class="w-5 h-5" fill="none"
                                        stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round"
                                            stroke-linejoin="round" stroke-width="2"
                                            d="M6 7h12m-10 0 1 13h6l1-13M9 7V4h6v3"/>
                                    </svg>
                                </button>
                            </form>
                        </div>

                    </div>
                </article>

            @endforeach

        </div>

        {{-- PAGINACIÓN --}}
        @if (method_exists($mascotas, 'links'))
            <div class="pt-4">
                {{ $mascotas->links() }}
            </div>
        @endif

    @else

        {{-- ESTADO VACÍO --}}
        <div class="bg-white border border-slate-200 rounded-2xl
                    shadow-sm py-16 px-6 text-center">

            <div class="w-20 h-20 mx-auto rounded-full bg-[#EAF4F5]
                        flex items-center justify-center mb-5">

                <svg class="w-10 h-10 text-[#40899A]" fill="none"
                    stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        stroke-width="1.5"
                        d="M12 12c2.5 0 4-2 4-4s-1.5-4-4-4-4 2-4 4 1.5 4 4 4zm-7 8c0-3.3 3.1-5 7-5s7 1.7 7 5"/>
                </svg>
            </div>

            <h3 class="text-lg font-bold text-slate-800">
                No hay mascotas registradas
            </h3>

            <p class="text-sm text-slate-500 mt-2 max-w-md mx-auto">
                Comienza registrando una mascota para que pueda encontrar
                una familia que le brinde un nuevo hogar.
            </p>

            <a href="{{ route('mascotasAdopcion.create') }}"
                class="inline-flex items-center gap-2 mt-6 px-5 py-3
                       rounded-xl bg-[#40899A] hover:bg-[#347889]
                       text-white text-sm font-semibold transition">

                Registrar primera mascota
            </a>
        </div>

    @endif

</div>

@endsection
