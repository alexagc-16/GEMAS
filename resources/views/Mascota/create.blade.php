@extends('layouts.app')

@section('title')
    Nueva mascota - Gemas
@endsection

@section('content')

    <div class="w-full max-w-3xl mx-auto space-y-6">

        {{-- Encabezado --}}
        <div>
            <h2 class="text-2xl font-bold text-slate-800">
                Registrar mascota
            </h2>

            <p class="mt-1 text-sm text-slate-500">
                Registra la información general de una nueva mascota.
            </p>
        </div>

        {{-- Errores de validación --}}
        @if($errors->any())
            <div class="rounded-xl border border-red-200 bg-red-50 p-4 text-red-700">
                <p class="font-semibold">
                    No se pudo registrar la mascota
                </p>

                <ul class="mt-2 list-disc space-y-1 pl-5 text-sm">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        {{-- Tarjeta del formulario --}}
        <div class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">

            {{-- Encabezado de la tarjeta --}}
            <div class="border-b border-slate-100 px-6 py-5">
                <div class="flex items-center gap-3">

                    <div class="flex h-11 w-11 items-center justify-center rounded-xl bg-[#EAF4F5] text-[#40899A]">
                        @include('layouts.partials.icons', ['icon' => 'mascota'])
                    </div>

                    <div>
                        <h3 class="font-semibold text-slate-800">
                            Información de la mascota
                        </h3>

                        <p class="text-sm text-slate-500">
                            Completa los datos para registrar a la mascota.
                        </p>
                    </div>

                </div>
            </div>

            <form action="{{ route('mascota.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="space-y-6 p-6">

                    {{-- Fotografía --}}
                    <div>
                        <h4 class="mb-4 text-sm font-semibold text-slate-700">
                            Fotografía
                        </h4>

                        <div class="flex flex-col items-center gap-4 rounded-xl border border-dashed border-slate-300 bg-slate-50/70 p-5 sm:flex-row sm:items-center">

                            {{-- Previsualización --}}
                            <div id="contenedorPreview"
                                class="flex h-32 w-32 shrink-0 items-center justify-center overflow-hidden rounded-xl border border-slate-200 bg-white">

                                <div id="placeholderImagen" class="flex flex-col items-center justify-center text-[#40899A]">
                                    @include('layouts.partials.icons', ['icon' => 'mascota'])

                                    <span class="mt-2 text-xs text-slate-400">
                                        Sin fotografía
                                    </span>
                                </div>

                                <img
                                    id="previewImagen"
                                    src=""
                                    alt="Vista previa de la fotografía"
                                    class="hidden h-full w-full object-cover"
                                >
                            </div>

                            {{-- Controles --}}
                            <div class="w-full flex-1">

                                <label for="imagen" class="mb-2 block text-sm font-medium text-slate-700">
                                    Seleccionar fotografía
                                </label>

                                <input
                                    type="file"
                                    name="imagen"
                                    id="imagen"
                                    accept="image/*"
                                    onchange="previsualizarImagen(event)"
                                    class="block w-full cursor-pointer rounded-lg border border-slate-300 bg-white text-sm text-slate-600 file:mr-4 file:cursor-pointer file:border-0 file:bg-[#EAF4F5] file:px-4 file:py-2.5 file:text-sm file:font-semibold file:text-[#40899A] hover:file:bg-[#d5ebed]"
                                >

                                <p class="mt-2 text-xs text-slate-500">
                                    Selecciona una imagen para identificar a la mascota.
                                </p>

                                <button
                                    type="button"
                                    id="btnEliminarImagen"
                                    onclick="eliminarImagen()"
                                    class="mt-3 hidden items-center gap-1.5 text-xs font-normal text-red-600 transition hover:text-red-700">

                                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                                            d="M6 7h12m-10 0V5h8v2m-9 0 1 13h8l1-13M10 11v5m4-5v5"/>
                                    </svg>

                                    Quitar fotografía
                                </button>

                            </div>

                        </div>
                    </div>

                    {{-- Datos de la mascota --}}
                    <div>
                        <h4 class="mb-4 text-sm font-semibold text-slate-700">
                            Datos generales
                        </h4>

                        <div class="grid grid-cols-1 gap-5 sm:grid-cols-2">

                            {{-- Nombre --}}
                            <div>
                                <label for="nombre" class="mb-2 block text-sm font-medium text-slate-700">
                                    Nombre <span class="text-red-500">*</span>
                                </label>

                                <input
                                    type="text"
                                    name="nombre"
                                    id="nombre"
                                    value="{{ old('nombre') }}"
                                    placeholder="Nombre de la mascota"
                                    required
                                    class="w-full rounded-lg border border-slate-300 px-3 py-2.5 text-sm text-slate-700 outline-none transition focus:border-teal-600 focus:ring-2 focus:ring-teal-100"
                                >
                            </div>

                            {{-- Especie --}}
                            <div>
                                <label for="especie" class="mb-2 block text-sm font-medium text-slate-700">
                                    Especie <span class="text-red-500">*</span>
                                </label>

                                <input
                                    type="text"
                                    name="especie"
                                    id="especie"
                                    value="{{ old('especie') }}"
                                    placeholder="Ej. Perro, gato..."
                                    required
                                    class="w-full rounded-lg border border-slate-300 px-3 py-2.5 text-sm text-slate-700 outline-none transition focus:border-teal-600 focus:ring-2 focus:ring-teal-100"
                                >
                            </div>

                            {{-- Raza --}}
                            <div>
                                <label for="raza" class="mb-2 block text-sm font-medium text-slate-700">
                                    Raza <span class="text-red-500">*</span>
                                </label>

                                <input
                                    type="text"
                                    name="raza"
                                    id="raza"
                                    value="{{ old('raza') }}"
                                    placeholder="Raza de la mascota"
                                    class="w-full rounded-lg border border-slate-300 px-3 py-2.5 text-sm text-slate-700 outline-none transition focus:border-teal-600 focus:ring-2 focus:ring-teal-100"
                                >
                            </div>

                            {{-- Sexo --}}
                            <div>
                                <label for="sexo" class="mb-2 block text-sm font-medium text-slate-700">
                                    Sexo <span class="text-red-500">*</span>
                                </label>

                                <select
                                    name="sexo"
                                    id="sexo"
                                    required
                                    class="w-full rounded-lg border border-slate-300 bg-white px-3 py-2.5 text-sm text-slate-700 outline-none transition focus:border-teal-600 focus:ring-2 focus:ring-teal-100"
                                >
                                    <option value="">Selecciona el sexo</option>

                                    <option value="Macho" {{ old('sexo') === 'Macho' ? 'selected' : '' }}>
                                        Macho
                                    </option>

                                    <option value="Hembra" {{ old('sexo') === 'Hembra' ? 'selected' : '' }}>
                                        Hembra
                                    </option>
                                </select>
                            </div>

                            {{-- Fecha de nacimiento --}}
                            <div>
                                <label for="fechaNacimiento" class="mb-2 block text-sm font-medium text-slate-700">
                                    Fecha de nacimiento <span class="text-red-500">*</span>
                                </label>

                                <input
                                    type="date"
                                    name="fechaNacimiento"
                                    id="fechaNacimiento"
                                    value="{{ old('fechaNacimiento') }}"
                                    max="{{ date('Y-m-d') }}"
                                    class="w-full rounded-lg border border-slate-300 px-3 py-2.5 text-sm text-slate-700 outline-none transition focus:border-teal-600 focus:ring-2 focus:ring-teal-100"
                                >
                            </div>

                            {{-- Color --}}
                            <div>
                                <label for="color" class="mb-2 block text-sm font-medium text-slate-700">
                                    Color <span class="text-red-500">*</span>
                                </label>

                                <input
                                    type="text"
                                    name="color"
                                    id="color"
                                    value="{{ old('color') }}"
                                    placeholder="Color de la mascota"
                                    class="w-full rounded-lg border border-slate-300 px-3 py-2.5 text-sm text-slate-700 outline-none transition focus:border-teal-600 focus:ring-2 focus:ring-teal-100"
                                >
                            </div>

                            {{-- Peso --}}
                            <div>
                                <label for="peso" class="mb-2 block text-sm font-medium text-slate-700">
                                    Peso (kg) <span class="text-red-500">*</span>
                                </label>

                                <input
                                    type="number"
                                    name="peso"
                                    id="peso"
                                    value="{{ old('peso') }}"
                                    min="0"
                                    step="0.01"
                                    placeholder="Ej. 5.50"
                                    class="w-full rounded-lg border border-slate-300 px-3 py-2.5 text-sm text-slate-700 outline-none transition focus:border-teal-600 focus:ring-2 focus:ring-teal-100"
                                >
                            </div>

                            {{-- Cuidador/Usuario --}}
                            <div>
                                <label for="idUsuario" class="mb-2 block text-sm font-medium text-slate-700">
                                    Cuidador <span class="text-red-500">*</span>
                                </label>

                                @if(auth()->user()->tieneRolActivo('usuario'))

                                    {{-- Usuario: cuidador asignado automáticamente --}}
                                    <input
                                        type="hidden"
                                        name="idUsuario"
                                        value="{{ auth()->id() }}"
                                    >

                                    <input
                                        type="text"
                                        value="{{ auth()->user()->nombre }} {{ auth()->user()->apellido }}"
                                        readonly
                                        class="w-full rounded-lg border border-slate-300 bg-slate-100 px-3 py-2.5 text-sm text-slate-600 cursor-not-allowed"
                                    >

                                    <p class="mt-1.5 text-xs text-slate-500">
                                        La mascota quedará registrada a tu nombre automáticamente.
                                    </p>

                                @else

                                    {{-- Administrador y veterinario: pueden seleccionar cuidador --}}
                                    <select
                                        name="idUsuario"
                                        id="idUsuario"
                                        required
                                        class="w-full rounded-lg border border-slate-300 bg-white px-3 py-2.5 text-sm text-slate-700 outline-none transition focus:border-teal-600 focus:ring-2 focus:ring-teal-100">

                                        <option value="">Selecciona un cuidador</option>

                                        @foreach($usuarios as $usuario)
                                            <option
                                                value="{{ $usuario->id }}"
                                                {{ (string) old('idUsuario') === (string) $usuario->id ? 'selected' : '' }}
                                            >
                                                {{ $usuario->nombre }} {{ $usuario->apellido }}
                                            </option>
                                        @endforeach

                                    </select>

                                    <p class="mt-1.5 text-xs text-slate-500">
                                        Selecciona la cuenta del usuario responsable de la mascota.
                                    </p>

                                @endif
                            </div>

                        </div>
                    </div>

                    

                </div>

                {{-- Botones --}}
                <div class="flex flex-col-reverse gap-3 border-t border-slate-100 bg-slate-50/70 px-6 py-4 sm:flex-row sm:justify-end">

                    <a href="{{ route('mascota.index') }}"
                        class="inline-flex items-center justify-center rounded-lg border border-slate-300 bg-white px-5 py-2.5 text-sm font-semibold text-slate-700 transition hover:bg-slate-100">
                        Cancelar
                    </a>

                    <button type="submit"
                        class="inline-flex items-center justify-center rounded-lg bg-teal-700 px-5 py-2.5 text-sm font-semibold text-white transition hover:bg-teal-800 focus:outline-none focus:ring-2 focus:ring-teal-500 focus:ring-offset-2">
                        Registrar mascota
                    </button>

                </div>

            </form>
        </div>

    </div>

    {{-- Previsualización de imagen --}}
    <script>
        function previsualizarImagen(event) {
            const archivo = event.target.files[0];

            if (!archivo) {
                return;
            }

            const preview = document.getElementById('previewImagen');
            const placeholder = document.getElementById('placeholderImagen');
            const botonEliminar = document.getElementById('btnEliminarImagen');

            preview.src = URL.createObjectURL(archivo);
            preview.classList.remove('hidden');

            placeholder.classList.add('hidden');

            botonEliminar.classList.remove('hidden');
            botonEliminar.classList.add('inline-flex');
        }

        function eliminarImagen() {
            const input = document.getElementById('imagen');
            const preview = document.getElementById('previewImagen');
            const placeholder = document.getElementById('placeholderImagen');
            const botonEliminar = document.getElementById('btnEliminarImagen');

            input.value = '';
            preview.src = '';
            preview.classList.add('hidden');

            placeholder.classList.remove('hidden');

            botonEliminar.classList.add('hidden');
            botonEliminar.classList.remove('inline-flex');
        }
    </script>

@endsection
