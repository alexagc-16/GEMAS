@extends('layouts.app')

@section('title', 'Registrar mascota - GEMAS')

@section('content')

<div class="w-full max-w-5xl mx-auto space-y-6">

    {{-- ENCABEZADO --}}
    <div>
        <a href="{{ route('mascotasAdopcion.index') }}"
            class="inline-flex items-center gap-2 text-sm font-semibold
                   text-[#40899A] hover:text-[#347889] transition mb-4">

            <svg class="w-4 h-4" fill="none" stroke="currentColor"
                viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round"
                    stroke-width="2" d="m15 18-6-6 6-6"/>
            </svg>

            Volver al listado
        </a>

        <h2 class="text-2xl font-bold text-slate-800">
            Registrar mascota
        </h2>

        <p class="text-sm text-slate-500 mt-1">
            Registra la información de una mascota que busca un nuevo hogar.
        </p>
    </div>

    {{-- ERRORES --}}
    @if ($errors->any())
        <div class="bg-red-50 border border-red-200 rounded-xl p-4">
            <p class="text-sm font-semibold text-red-700 mb-2">
                Revisa los siguientes campos:
            </p>

            <ul class="list-disc pl-5 text-sm text-red-600 space-y-1">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('mascotasAdopcion.store') }}"
        method="POST" enctype="multipart/form-data"
        class="space-y-6">

        @csrf

        {{-- INFORMACIÓN GENERAL --}}
        <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">

            <div class="px-6 py-5 border-b border-slate-100
                        flex items-center gap-3">

                <div class="w-10 h-10 rounded-xl bg-[#EAF4F5]
                            flex items-center justify-center">
                    <svg class="w-5 h-5 text-[#40899A]" fill="none"
                        stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            stroke-width="1.8"
                            d="M12 12c2.5 0 4-2 4-4s-1.5-4-4-4-4 2-4 4 1.5 4 4 4zm-7 8c0-3.3 3.1-5 7-5s7 1.7 7 5"/>
                    </svg>
                </div>

                <div>
                    <h3 class="font-bold text-slate-800">
                        Información de la mascota
                    </h3>
                    <p class="text-xs text-slate-500 mt-1">
                        Datos generales y características
                    </p>
                </div>
            </div>

            <div class="p-6 grid grid-cols-1 md:grid-cols-2 gap-5">

                {{-- NOMBRE --}}
                <div>
                    <label for="nombre" class="block text-sm font-semibold text-slate-700 mb-2">
                        Nombre <span class="text-red-500">*</span>
                    </label>

                    <input type="text" id="nombre" name="nombre"
                        value="{{ old('nombre') }}"
                        maxlength="50" required
                        placeholder="Nombre de la mascota"
                        class="w-full px-4 py-3 rounded-xl border border-slate-200
                               bg-slate-50 text-sm text-slate-700 outline-none
                               focus:border-[#40899A] focus:ring-2
                               focus:ring-[#40899A]/20">

                    @error('nombre')
                        <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- ESPECIE --}}
                <div>
                    <label for="especie" class="block text-sm font-semibold text-slate-700 mb-2">
                        Especie <span class="text-red-500">*</span>
                    </label>

                    <input type="text" id="especie" name="especie"
                        value="{{ old('especie') }}"
                        maxlength="50"
                        placeholder="Especie de la mascota"
                        class="w-full px-4 py-3 rounded-xl border border-slate-200
                               bg-slate-50 text-sm text-slate-700 outline-none
                               focus:border-[#40899A] focus:ring-2
                               focus:ring-[#40899A]/20">

                    @error('especie')
                        <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- RAZA --}}
                <div>
                    <label for="raza" class="block text-sm font-semibold text-slate-700 mb-2">
                        Raza
                    </label>

                    <input type="text" id="raza" name="raza"
                        value="{{ old('raza') }}"
                        maxlength="50"
                        placeholder="Raza de la mascota"
                        class="w-full px-4 py-3 rounded-xl border border-slate-200
                               bg-slate-50 text-sm text-slate-700 outline-none
                               focus:border-[#40899A] focus:ring-2
                               focus:ring-[#40899A]/20">

                    @error('raza')
                        <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- SEXO --}}
                <div>
                    <label for="sexo" class="block text-sm font-semibold text-slate-700 mb-2">
                        Sexo <span class="text-red-500">*</span>
                    </label>

                    <select id="sexo" name="sexo" required
                        class="w-full px-4 py-3 rounded-xl border border-slate-200
                               bg-slate-50 text-sm text-slate-700 outline-none
                               focus:border-[#40899A] focus:ring-2
                               focus:ring-[#40899A]/20">

                        <option value="">Selecciona el sexo</option>
                        <option value="Macho" @selected(old('sexo') === 'Macho')>Macho</option>
                        <option value="Hembra" @selected(old('sexo') === 'Hembra')>Hembra</option>
                    </select>

                    @error('sexo')
                        <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- FECHA DE NACIMIENTO --}}
                <div>
                    <label for="fechaNacimiento" class="block text-sm font-semibold text-slate-700 mb-2">
                        Fecha de nacimiento
                    </label>

                    <input type="date" id="fechaNacimiento"
                        name="fechaNacimiento"
                        value="{{ old('fechaNacimiento') }}"
                        max="{{ date('Y-m-d') }}"
                        class="w-full px-4 py-3 rounded-xl border border-slate-200
                               bg-slate-50 text-sm text-slate-700 outline-none
                               focus:border-[#40899A] focus:ring-2
                               focus:ring-[#40899A]/20">

                    @error('fechaNacimiento')
                        <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- COLOR --}}
                <div>
                    <label for="color" class="block text-sm font-semibold text-slate-700 mb-2">
                        Color
                    </label>

                    <input type="text" id="color" name="color"
                        value="{{ old('color') }}"
                        maxlength="50"
                        placeholder="Ej. Café, blanco, negro..."
                        class="w-full px-4 py-3 rounded-xl border border-slate-200
                               bg-slate-50 text-sm text-slate-700 outline-none
                               focus:border-[#40899A] focus:ring-2
                               focus:ring-[#40899A]/20">

                    @error('color')
                        <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- PESO --}}
                <div>
                    <label for="peso" class="block text-sm font-semibold text-slate-700 mb-2">
                        Peso (kg)
                    </label>

                    <input type="number" id="peso" name="peso"
                        value="{{ old('peso') }}"
                        min="0.01" max="99999999.99" step="0.01"
                        placeholder="Ej. 5.50"
                        class="w-full px-4 py-3 rounded-xl border border-slate-200
                               bg-slate-50 text-sm text-slate-700 outline-none
                               focus:border-[#40899A] focus:ring-2
                               focus:ring-[#40899A]/20">

                    @error('peso')
                        <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- ESTADO --}}
                <div>
                    <label for="estado" class="block text-sm font-semibold text-slate-700 mb-2">
                        Estado <span class="text-red-500">*</span>
                    </label>

                    <select id="estado" name="estado" required
                        class="w-full px-4 py-3 rounded-xl border border-slate-200
                               bg-slate-50 text-sm text-slate-700 outline-none
                               focus:border-[#40899A] focus:ring-2
                               focus:ring-[#40899A]/20">

                        <option value="En adopción"
                            @selected(old('estado', 'En adopción') === 'En adopción')>
                            En adopción
                        </option>

                        <option value="Adoptada"
                            @selected(old('estado') === 'Adoptada')>
                            Adoptada
                        </option>

                        <option value="No disponible"
                            @selected(old('estado') === 'No disponible')>
                            No disponible
                        </option>
                    </select>

                    @error('estado')
                        <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- DESCRIPCIÓN --}}
                <div class="md:col-span-2">
                    <label for="descripcion" class="block text-sm font-semibold text-slate-700 mb-2">
                        Descripción
                    </label>

                    <textarea id="descripcion" name="descripcion"
                        rows="4" maxlength="700"
                        placeholder="Describe su personalidad, comportamiento y características..."
                        class="w-full px-4 py-3 rounded-xl border border-slate-200
                               bg-slate-50 text-sm text-slate-700 outline-none
                               resize-y focus:border-[#40899A]
                               focus:ring-2 focus:ring-[#40899A]/20">{{ old('descripcion') }}</textarea>

                    @error('descripcion')
                        <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                    @enderror
                </div>

            </div>
        </div>

        {{-- FOTOGRAFÍA --}}
        <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">

            <div class="px-6 py-5 border-b border-slate-100
                        flex items-center gap-3">

                <div class="w-10 h-10 rounded-xl bg-[#EAF4F5]
                            flex items-center justify-center">
                    <svg class="w-5 h-5 text-[#40899A]" fill="none"
                        stroke="currentColor" viewBox="0 0 24 24">
                        <rect x="3" y="3" width="18" height="18"
                            rx="2" stroke-width="1.8"/>
                        <circle cx="8.5" cy="8.5" r="1.5"/>
                        <path stroke-width="1.8" d="m21 15-5-5L5 21"/>
                    </svg>
                </div>

                <div>
                    <h3 class="font-bold text-slate-800">
                        Fotografía de la mascota
                    </h3>
                    <p class="text-xs text-slate-500 mt-1">
                        Selecciona una imagen para identificarla en el catálogo.
                    </p>
                </div>
            </div>

            <div class="p-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 items-center">

                    <div>
                        <label for="imagen"
                            class="block text-sm font-semibold text-slate-700 mb-2">
                            Seleccionar imagen <span class="text-red-500">*</span>
                        </label>

                        <input type="file" id="imagen" name="imagen"
                            accept=".jpg,.jpeg,.png,.webp,image/jpeg,image/png,image/webp"
                            required
                            class="w-full text-sm text-slate-600
                                   file:mr-4 file:py-2.5 file:px-4
                                   file:rounded-lg file:border-0
                                   file:bg-[#EAF4F5] file:text-[#347889]
                                   file:font-semibold hover:file:bg-[#DCEEF2]">

                        <p class="text-xs text-slate-400 mt-3">
                            Formatos permitidos: JPG, JPEG, PNG y WEBP.
                            Tamaño máximo: 2 MB.
                        </p>

                        @error('imagen')
                            <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="flex justify-center">
                        <div class="w-full max-w-xs h-52 rounded-2xl
                                    bg-[#EAF4F5] border border-dashed
                                    border-[#A0CED7] overflow-hidden
                                    flex items-center justify-center">

                            <img id="previewImagen"
                                src=""
                                alt="Previsualización"
                                class="hidden w-full h-full object-contain p-2">

                            <div id="mensajeImagen"
                                class="text-center text-slate-400">

                                <svg class="w-12 h-12 mx-auto mb-2"
                                    fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <rect x="3" y="3" width="18" height="18"
                                        rx="2" stroke-width="1.5"/>
                                    <circle cx="8.5" cy="8.5" r="1.5"/>
                                    <path stroke-width="1.5"
                                        d="m21 15-5-5L5 21"/>
                                </svg>

                                <p class="text-xs">Vista previa de la imagen</p>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>

        {{-- BOTONES --}}
        <div class="flex flex-col-reverse sm:flex-row
                    justify-end gap-3 pb-6">

            <a href="{{ route('mascotasAdopcion.index') }}"
                class="inline-flex items-center justify-center px-6 py-3
                       rounded-xl border border-slate-300 bg-white
                       text-slate-600 hover:bg-slate-50
                       text-sm font-semibold transition">
                Cancelar
            </a>

            <button type="submit"
                class="inline-flex items-center justify-center gap-2
                       px-6 py-3 rounded-xl bg-[#40899A]
                       hover:bg-[#347889] text-white
                       text-sm font-semibold transition shadow-sm">

                Guardar mascota
            </button>
        </div>

    </form>
</div>

{{-- PREVISUALIZACIÓN --}}
<script>
    document.addEventListener('DOMContentLoaded', function () {

        const inputImagen = document.getElementById('imagen');
        const previewImagen = document.getElementById('previewImagen');
        const mensajeImagen = document.getElementById('mensajeImagen');

        inputImagen.addEventListener('change', function () {

            const archivo = this.files[0];

            if (!archivo) {
                previewImagen.src = '';
                previewImagen.classList.add('hidden');
                mensajeImagen.classList.remove('hidden');
                return;
            }

            const tiposPermitidos = [
                'image/jpeg',
                'image/png',
                'image/webp'
            ];

            if (!tiposPermitidos.includes(archivo.type)) {
                alert('Selecciona una imagen JPG, JPEG, PNG o WEBP.');
                this.value = '';
                return;
            }

            if (archivo.size > 2 * 1024 * 1024) {
                alert('La imagen no puede superar los 2 MB.');
                this.value = '';
                return;
            }

            const lector = new FileReader();

            lector.onload = function (evento) {
                previewImagen.src = evento.target.result;
                previewImagen.classList.remove('hidden');
                mensajeImagen.classList.add('hidden');
            };

            lector.readAsDataURL(archivo);
        });
    });
</script>

@endsection
