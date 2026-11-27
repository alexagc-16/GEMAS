@extends('layouts.app')

@section('title')
    Editar veterinario - Gemas
@endsection

@section('content')

    <div class="w-full max-w-3xl mx-auto space-y-6">

        {{-- Encabezado --}}
        <div>
            <h2 class="text-2xl font-bold text-slate-800">
                Editar veterinario
            </h2>

            <p class="mt-1 text-sm text-slate-500">
                Actualiza la información de {{ $veterinario->nombre }} {{ $veterinario->apellido }}.
            </p>
        </div>

        {{-- Errores de validación --}}
        @if ($errors->any())
            <div class="rounded-xl border border-red-200 bg-red-50 p-4 text-red-700">
                <p class="font-semibold">No se pudo actualizar el veterinario</p>

                <ul class="mt-2 list-disc space-y-1 pl-5 text-sm">
                    @foreach ($errors->all() as $error)
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
                        @include('layouts.partials.icons', ['icon' => 'veterinario'])
                    </div>

                    <div>
                        <h3 class="font-semibold text-slate-800">
                            Información profesional
                        </h3>

                        <p class="text-sm text-slate-500">
                            Modifica los datos personales y profesionales.
                        </p>
                    </div>

                </div>
            </div>

            <form action="{{ route('veterinario.update', $veterinario->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="space-y-6 p-6">

                    {{-- Datos personales --}}
                    <div>
                        <h4 class="mb-4 text-sm font-semibold text-slate-700">
                            Datos personales
                        </h4>

                        <div class="grid grid-cols-1 gap-5 sm:grid-cols-2">

                            {{-- Nombre --}}
                            <div>
                                <label for="nombre" class="mb-2 block text-sm font-medium text-slate-700">
                                    Nombre <span class="text-red-500">*</span>
                                </label>

                                <input type="text" name="nombre" id="nombre"
                                    value="{{ old('nombre', $veterinario->nombre) }}"
                                    placeholder="Nombre del veterinario"
                                    required
                                    class="w-full rounded-lg border border-slate-300 px-3 py-2.5 text-sm text-slate-700 outline-none transition focus:border-primary-600 focus:ring-2 focus:ring-primary-100">
                            </div>

                            {{-- Apellido --}}
                            <div>
                                <label for="apellido" class="mb-2 block text-sm font-medium text-slate-700">
                                    Apellido <span class="text-red-500">*</span>
                                </label>

                                <input type="text" name="apellido" id="apellido"
                                    value="{{ old('apellido', $veterinario->apellido) }}"
                                    placeholder="Apellido del veterinario"
                                    required
                                    class="w-full rounded-lg border border-slate-300 px-3 py-2.5 text-sm text-slate-700 outline-none transition focus:border-primary-600 focus:ring-2 focus:ring-primary-100">
                            </div>

                            {{-- Documento --}}
                            <div>
                                <label for="documentoIdentidad" class="mb-2 block text-sm font-medium text-slate-700">
                                    Documento de identidad <span class="text-red-500">*</span>
                                </label>

                                <input type="text" name="documentoIdentidad" id="documentoIdentidad"
                                    value="{{ old('documentoIdentidad', $veterinario->documentoIdentidad) }}"
                                    placeholder="Número de documento"
                                    required
                                    class="w-full rounded-lg border border-slate-300 px-3 py-2.5 text-sm text-slate-700 outline-none transition focus:border-primary-600 focus:ring-2 focus:ring-primary-100">
                            </div>

                            {{-- Teléfono --}}
                            <div>
                                <label for="telefono" class="mb-2 block text-sm font-medium text-slate-700">
                                    Teléfono <span class="text-red-500">*</span>
                                </label>

                                <input type="text" name="telefono" id="telefono"
                                    value="{{ old('telefono', $veterinario->telefono) }}"
                                    placeholder="Número de teléfono"
                                    required
                                    class="w-full rounded-lg border border-slate-300 px-3 py-2.5 text-sm text-slate-700 outline-none transition focus:border-primary-600 focus:ring-2 focus:ring-primary-100">
                            </div>

                            {{-- Correo --}}
                            <div>
                                <label for="email" class="mb-2 block text-sm font-medium text-slate-700">
                                    Correo electrónico <span class="text-red-500">*</span>
                                </label>

                                <input type="email" name="email" id="email"
                                    value="{{ old('email', $veterinario->email) }}"
                                    placeholder="correo@ejemplo.com"
                                    required
                                    class="w-full rounded-lg border border-slate-300 px-3 py-2.5 text-sm text-slate-700 outline-none transition focus:border-primary-600 focus:ring-2 focus:ring-primary-100">
                            </div>

                            {{-- Especialidad --}}
                            <div>
                                <label for="especialidad" class="mb-2 block text-sm font-medium text-slate-700">
                                    Especialidad <span class="text-red-500">*</span>
                                </label>

                                <input type="text" name="especialidad" id="especialidad"
                                    value="{{ old('especialidad', $veterinario->especialidad) }}"
                                    placeholder="Ej. Medicina interna"
                                    required
                                    class="w-full rounded-lg border border-slate-300 px-3 py-2.5 text-sm text-slate-700 outline-none transition focus:border-primary-600 focus:ring-2 focus:ring-primary-100">
                            </div>

                        </div>
                    </div>

                </div>

                {{-- Botones --}}
                <div class="flex flex-col-reverse gap-3 border-t border-slate-100 bg-slate-50/70 px-6 py-4 sm:flex-row sm:justify-end">

                    <a href="{{ route('veterinario.index') }}"
                        class="inline-flex items-center justify-center rounded-lg border border-slate-300 bg-white px-5 py-2.5 text-sm font-semibold text-slate-700 transition hover:bg-slate-100">
                        Cancelar
                    </a>

                    <button type="submit"
                        class="inline-flex items-center justify-center rounded-lg bg-primary-600 px-5 py-2.5 text-sm font-semibold text-white transition hover:bg-primary-700 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:ring-offset-2">
                        Guardar cambios
                    </button>

                </div>

            </form>
        </div>
    </div>

@endsection