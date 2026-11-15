@extends('layouts.app')

@section('title')
    Editar Servicio - Gemas
@endsection

@section('content')

    <div class="w-full max-w-3xl mx-auto space-y-6">

        {{-- Encabezado --}}
        <div>
            <h2 class="text-2xl font-bold text-slate-800">
                Editar servicio
            </h2>

            <p class="mt-1 text-sm text-slate-500">
                Actualiza la información del servicio seleccionado.
            </p>
        </div>

        {{-- Errores de validación --}}
        @if ($errors->any())
            <div class="rounded-xl border border-red-200 bg-red-50 p-4 text-red-700">
                <p class="font-semibold">No se pudo actualizar el servicio</p>

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
                        @include('layouts.partials.icons', ['icon' => 'servicio'])
                    </div>

                    <div>
                        <h3 class="font-semibold text-slate-800">
                            Información del servicio
                        </h3>

                        <p class="text-sm text-slate-500">
                            Modifica los datos que necesites actualizar.
                        </p>
                    </div>

                </div>
            </div>

            <form action="{{ route('servicio.update', $servicio->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="space-y-6 p-6">

                    {{-- Datos del servicio --}}
                    <div>
                        <h4 class="mb-4 text-sm font-semibold text-slate-700">
                            Datos generales
                        </h4>

                        <div class="grid grid-cols-1 gap-5 sm:grid-cols-2">

                            {{-- Nombre --}}
                            <div class="sm:col-span-2">
                                <label for="nombre" class="mb-2 block text-sm font-medium text-slate-700">
                                    Nombre del servicio <span class="text-red-500">*</span>
                                </label>

                                <input
                                    type="text"
                                    name="nombre"
                                    id="nombre"
                                    value="{{ old('nombre', $servicio->nombre) }}"
                                    maxlength="255"
                                    required
                                    class="w-full rounded-lg border border-slate-300 px-3 py-2.5 text-sm text-slate-700 outline-none transition focus:border-primary-600 focus:ring-2 focus:ring-primary-100"
                                >

                                @error('nombre')
                                    <p class="mt-1.5 text-xs text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            {{-- Duración --}}
                            <div class="sm:col-span-2">
                                <label for="duracionMinutos" class="mb-2 block text-sm font-medium text-slate-700">
                                    Duración del servicio <span class="text-red-500">*</span>
                                </label>

                                <div class="relative">
                                    <input
                                        type="number"
                                        name="duracionMinutos"
                                        id="duracionMinutos"
                                        value="{{ old('duracionMinutos', $servicio->duracionMinutos) }}"
                                        min="1"
                                        max="240"
                                        step="1"
                                        required
                                        class="w-full rounded-lg border border-slate-300 px-3 py-2.5 pr-20 text-sm text-slate-700 outline-none transition focus:border-primary-600 focus:ring-2 focus:ring-primary-100"
                                    >

                                    <span class="pointer-events-none absolute inset-y-0 right-4 flex items-center text-sm text-slate-400">
                                        minutos
                                    </span>
                                </div>

                                <p class="mt-1.5 text-xs text-slate-500">
                                    Entre 1 y 240 minutos.
                                </p>

                                @error('duracionMinutos')
                                    <p class="mt-1.5 text-xs text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            {{-- Descripción --}}
                            <div class="sm:col-span-2">
                                <label for="descripcion" class="mb-2 block text-sm font-medium text-slate-700">
                                    Descripción
                                </label>

                                <textarea
                                    name="descripcion"
                                    id="descripcion"
                                    rows="4"
                                    placeholder="Describe brevemente en qué consiste el servicio..."
                                    class="w-full resize-y rounded-lg border border-slate-300 px-3 py-2.5 text-sm text-slate-700 outline-none transition focus:border-primary-600 focus:ring-2 focus:ring-primary-100"
                                >{{ old('descripcion', $servicio->descripcion) }}</textarea>

                                @error('descripcion')
                                    <p class="mt-1.5 text-xs text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                        </div>
                    </div>

                </div>

                {{-- Botones --}}
                <div class="flex flex-col-reverse gap-3 border-t border-slate-100 bg-slate-50/70 px-6 py-4 sm:flex-row sm:justify-end">

                    <a
                        href="{{ route('servicio.index') }}"
                        class="inline-flex items-center justify-center rounded-lg border border-slate-300 bg-white px-5 py-2.5 text-sm font-semibold text-slate-700 transition hover:bg-slate-100"
                    >
                        Cancelar
                    </a>

                    <button
                        type="submit"
                        class="inline-flex items-center justify-center rounded-lg bg-primary-600 px-5 py-2.5 text-sm font-semibold text-white transition hover:bg-primary-700 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:ring-offset-2"
                    >
                        Guardar cambios
                    </button>

                </div>

            </form>
        </div>
    </div>

@endsection