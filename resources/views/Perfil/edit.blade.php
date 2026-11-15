@extends('layouts.app')

@section('title')
    Editar perfil - Gemas
@endsection

@section('content')

    <div class="w-full max-w-4xl mx-auto space-y-6">

        {{-- Encabezado --}}
        <div>
            <h1 class="text-xl sm:text-2xl font-bold text-slate-800">
                Editar perfil
            </h1>

            <p class="mt-1 text-sm text-slate-500">
                Actualiza tu información personal.
            </p>
        </div>

        {{-- Tarjeta del formulario --}}
        <div class="overflow-hidden rounded-xl border border-slate-200 bg-white shadow-sm">

            {{-- Encabezado de la tarjeta --}}
            <div class="border-b border-slate-200 px-5 py-4 sm:px-6">

                <div class="flex items-center gap-3">

                    <div class="flex h-11 w-11 items-center justify-center rounded-xl bg-[#EAF4F5] text-[#40899A]">
                        @include('layouts.partials.icons', ['icon' => 'usuario'])
                    </div>

                    <div>
                        <h2 class="text-base font-semibold text-slate-800">
                            Información personal
                        </h2>

                        <p class="mt-0.5 text-xs text-slate-500">
                            Modifica los datos asociados a tu cuenta.
                        </p>
                    </div>

                </div>

            </div>

            {{-- Errores de validación --}}
            @if ($errors->any())
                <div class="mx-5 mt-5 rounded-lg border border-red-200 bg-red-50 p-4 sm:mx-6">

                    <div class="flex items-start gap-3">

                        <svg class="mt-0.5 h-5 w-5 shrink-0 text-red-500"
                            fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                stroke-width="2"
                                d="M12 9v4m0 4h.01M10.3 3.86L1.82 18a2 2 0 001.7 3h16.96a2 2 0 001.7-3L13.7 3.86a2 2 0 00-3.4 0z" />
                        </svg>

                        <div>
                            <p class="text-sm font-semibold text-red-700">
                                Por favor, revisa los siguientes errores:
                            </p>

                            <ul class="mt-2 list-disc space-y-1 pl-5 text-sm text-red-600">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>

                    </div>

                </div>
            @endif

            <form action="{{ route('perfil.update') }}" method="POST">

                @csrf
                @method('PUT')

                <div class="space-y-8 p-5 sm:p-6">

                    {{-- Datos personales --}}
                    <section>

                        <div class="mb-5">
                            <h3 class="text-sm font-semibold text-slate-800">
                                Datos personales
                            </h3>

                            <p class="mt-1 text-xs text-slate-500">
                                Información básica de tu cuenta.
                            </p>
                        </div>

                        <div class="grid grid-cols-1 gap-5 md:grid-cols-2">

                            {{-- Nombre --}}
                            <div>
                                <label for="nombre"
                                    class="mb-2 block text-sm font-medium text-slate-700">
                                    Nombre
                                    <span class="text-red-500">*</span>
                                </label>

                                <input
                                    type="text"
                                    id="nombre"
                                    name="nombre"
                                    value="{{ old('nombre', $perfil['usuario']->nombre) }}"
                                    required
                                    class="w-full rounded-lg border border-slate-300 bg-white px-3.5 py-2.5 text-sm text-slate-700 outline-none transition focus:border-[#40899A] focus:ring-2 focus:ring-[#40899A]/20">
                            </div>

                            {{-- Apellido --}}
                            <div>
                                <label for="apellido"
                                    class="mb-2 block text-sm font-medium text-slate-700">
                                    Apellido
                                    <span class="text-red-500">*</span>
                                </label>

                                <input
                                    type="text"
                                    id="apellido"
                                    name="apellido"
                                    value="{{ old('apellido', $perfil['usuario']->apellido) }}"
                                    required
                                    class="w-full rounded-lg border border-slate-300 bg-white px-3.5 py-2.5 text-sm text-slate-700 outline-none transition focus:border-[#40899A] focus:ring-2 focus:ring-[#40899A]/20">
                            </div>

                            {{-- Documento --}}
                            <div>
                                <label for="documentoIdentidad"
                                    class="mb-2 block text-sm font-medium text-slate-700">
                                    Documento de identidad
                                </label>

                                <input
                                    type="text"
                                    id="documentoIdentidad"
                                    value="{{ $perfil['usuario']->documentoIdentidad }}"
                                    disabled
                                    class="w-full cursor-not-allowed rounded-lg border border-slate-200 bg-slate-100 px-3.5 py-2.5 text-sm text-slate-500">

                                <p class="mt-1.5 text-xs text-slate-400">
                                    Este dato no se puede modificar desde el perfil.
                                </p>
                            </div>

                            {{-- Teléfono --}}
                            <div>
                                <label for="telefono"
                                    class="mb-2 block text-sm font-medium text-slate-700">
                                    Teléfono
                                    <span class="text-red-500">*</span>
                                </label>

                                <input
                                    type="text"
                                    id="telefono"
                                    name="telefono"
                                    value="{{ old('telefono', $perfil['usuario']->telefono) }}"
                                    required
                                    class="w-full rounded-lg border border-slate-300 bg-white px-3.5 py-2.5 text-sm text-slate-700 outline-none transition focus:border-[#40899A] focus:ring-2 focus:ring-[#40899A]/20">
                            </div>

                            {{-- Correo electrónico --}}
                            <div class="md:col-span-2">
                                <label for="email"
                                    class="mb-2 block text-sm font-medium text-slate-700">
                                    Correo electrónico
                                    <span class="text-red-500">*</span>
                                </label>

                                <input
                                    type="email"
                                    id="email"
                                    name="email"
                                    value="{{ old('email', $perfil['usuario']->email) }}"
                                    required
                                    class="w-full rounded-lg border border-slate-300 bg-white px-3.5 py-2.5 text-sm text-slate-700 outline-none transition focus:border-[#40899A] focus:ring-2 focus:ring-[#40899A]/20">
                            </div>

                            {{-- Dirección: solo usuario --}}
                            @if (!$perfil['veterinario'] && !$esAdministrador)

                                <div class="md:col-span-2">
                                    <label for="direccion"
                                        class="mb-2 block text-sm font-medium text-slate-700">
                                        Dirección
                                    </label>

                                    <input
                                        type="text"
                                        id="direccion"
                                        name="direccion"
                                        value="{{ old('direccion', $perfil['usuario']->direccion) }}"
                                        class="w-full rounded-lg border border-slate-300 bg-white px-3.5 py-2.5 text-sm text-slate-700 outline-none transition focus:border-[#40899A] focus:ring-2 focus:ring-[#40899A]/20">
                                </div>

                            @endif

                        </div>

                    </section>

                    {{-- Información profesional --}}
                    @if ($perfil['veterinario'])

                        <div class="border-t border-slate-200"></div>

                        <section>

                            <div class="mb-5">
                                <h3 class="text-sm font-semibold text-slate-800">
                                    Información profesional
                                </h3>

                                <p class="mt-1 text-xs text-slate-500">
                                    Datos relacionados con tu especialidad veterinaria.
                                </p>
                            </div>

                            <div>
                                <label for="especialidad"
                                    class="mb-2 block text-sm font-medium text-slate-700">
                                    Especialidad
                                </label>

                                <input
                                    type="text"
                                    id="especialidad"
                                    value="{{ $perfil['veterinario']->especialidad }}"
                                    disabled
                                    class="w-full cursor-not-allowed rounded-lg border border-slate-200 bg-slate-100 px-3.5 py-2.5 text-sm text-slate-500">

                                <p class="mt-1.5 text-xs text-slate-400">
                                    La especialidad no se puede modificar desde el perfil.
                                </p>
                            </div>

                        </section>

                    @endif

                </div>

                {{-- Botones --}}
                <div class="flex flex-col-reverse gap-3 border-t border-slate-200 bg-slate-50 px-5 py-4 sm:flex-row sm:justify-end sm:px-6">

                    <a href="{{ route('perfil.index') }}"
                        class="inline-flex items-center justify-center rounded-lg border border-slate-300 bg-white px-5 py-2.5 text-sm font-medium text-slate-600 transition hover:bg-slate-100">
                        Cancelar
                    </a>

                    <button type="submit"
                        class="inline-flex items-center justify-center gap-2 rounded-lg bg-[#40899A] px-5 py-2.5 text-sm font-semibold text-white transition hover:bg-[#347483]">

                        <svg class="h-4 w-4" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                stroke-width="2" d="M5 13l4 4L19 7" />
                        </svg>

                        Guardar cambios
                    </button>

                </div>

            </form>

        </div>

    </div>

@endsection
