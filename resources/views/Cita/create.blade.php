@extends('layouts.app')

@section('title')
    Nueva cita - Gemas
@endsection

@section('content')
 
    <div class="w-full max-w-3xl mx-auto space-y-6">

        {{-- Encabezado --}}
        <div>
            <h2 class="text-2xl font-bold text-slate-800">
                Nueva cita
            </h2>

            <p class="mt-1 text-sm text-slate-500">
                Registra una nueva cita para la atención veterinaria.
            </p>
        </div>

        {{-- Errores de validación --}}
        @if ($errors->any())
            <div class="rounded-xl border border-red-200 bg-red-50 p-4 text-red-700">
                <p class="font-semibold">No se pudo registrar la cita</p>

                <ul class="mt-2 list-disc space-y-1 pl-5 text-sm">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        {{-- Tarjeta del formulario --}}
        <div class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">

            <div class="border-b border-slate-100 px-6 py-5">
                <div class="flex items-center gap-3">
                    <div class="flex h-11 w-11 items-center justify-center rounded-xl bg-[#EAF4F5] text-slate-700">
                        @include('layouts.partials.icons', ['icon' => 'cita'])
                    </div>

                    <div>
                        <h3 class="font-semibold text-slate-800">
                            Información de la cita
                        </h3>
                        <p class="text-sm text-slate-500">
                            Completa los campos para programar la atención.
                        </p>
                    </div>
                </div>
            </div>

            <form action="{{ route('cita.store') }}" method="POST">
                @csrf

                <div class="space-y-6 p-6">

                    {{-- Fecha y hora --}}
                    <div>
                        <h4 class="mb-4 text-sm font-semibold text-slate-700">
                            Fecha y horario
                        </h4>

                        <div class="grid grid-cols-1 gap-5 sm:grid-cols-2">

                            <div>
                                <label for="fecha" class="mb-2 block text-sm font-medium text-slate-700">
                                    Fecha <span class="text-red-500">*</span>
                                </label>

                                <input
                                    type="date"
                                    id="fecha"
                                    name="fecha"
                                    value="{{ old('fecha') }}"
                                    min="{{ date('Y-m-d') }}"
                                    required
                                    class="w-full rounded-lg border border-slate-300 px-3 py-2.5 text-sm text-slate-700 outline-none transition focus:border-teal-600 focus:ring-2 focus:ring-teal-100"
                                >
                            </div>

                            <div>
                                <label for="hora" class="mb-2 block text-sm font-medium text-slate-700">
                                    Hora <span class="text-red-500">*</span>
                                </label>

                                <input
                                    type="time"
                                    id="hora"
                                    name="hora"
                                    value="{{ old('hora') }}"
                                    required
                                    class="w-full rounded-lg border border-slate-300 px-3 py-2.5 text-sm text-slate-700 outline-none transition focus:border-teal-600 focus:ring-2 focus:ring-teal-100"
                                >
                            </div>

                        </div>
                    </div>

                    {{-- Motivo --}}
                    <div>
                        <label for="motivo" class="mb-2 block text-sm font-medium text-slate-700">
                            Motivo de la cita <span class="text-red-500">*</span>
                        </label>

                        <textarea
                            id="motivo"
                            name="motivo"
                            rows="3"
                            maxlength="150"
                            required
                            placeholder="Describe el motivo de la consulta..."
                            class="w-full resize-y rounded-lg border border-slate-300 px-3 py-2.5 text-sm text-slate-700 outline-none transition focus:border-teal-600 focus:ring-2 focus:ring-teal-100"
                        >{{ old('motivo') }}</textarea>

                        <p class="mt-1 text-xs text-slate-500">
                            Máximo 150 caracteres.
                        </p>
                    </div>

                    {{-- Mascota --}}
                    <div>
                        <label for="idMascota" class="mb-2 block text-sm font-medium text-slate-700">
                            Mascota <span class="text-red-500">*</span>
                        </label>

                        <select
                            id="idMascota"
                            name="idMascota"
                            required
                            class="w-full rounded-lg border border-slate-300 bg-white px-3 py-2.5 text-sm text-slate-700 outline-none transition focus:border-teal-600 focus:ring-2 focus:ring-teal-100"
                        >
                            <option value="">Selecciona una mascota</option>

                            @foreach ($mascotas as $mascota)
                                <option
                                    value="{{ $mascota->id }}"
                                    {{ (string) old('idMascota') === (string) $mascota->id ? 'selected' : '' }}
                                >
                                    {{ $mascota->nombre }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Veterinario --}}
                    <div>
                        <label for="idVeterinario" class="mb-2 block text-sm font-medium text-slate-700">
                            Veterinario <span class="text-red-500">*</span>
                        </label>

                        <select
                            id="idVeterinario"
                            name="idVeterinario"
                            required
                            class="w-full rounded-lg border border-slate-300 bg-white px-3 py-2.5 text-sm text-slate-700 outline-none transition focus:border-teal-600 focus:ring-2 focus:ring-teal-100"
                        >
                            <option value="">Selecciona un veterinario</option>

                            @foreach ($veterinarios as $veterinario)
                                <option
                                    value="{{ $veterinario->id }}"
                                    {{ (string) old('idVeterinario') === (string) $veterinario->id ? 'selected' : '' }}
                                >
                                    {{ $veterinario->nombre }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Servicio --}}
                    <div>
                        <label for="idServicio" class="mb-2 block text-sm font-medium text-slate-700">
                            Servicio <span class="text-red-500">*</span>
                        </label>

                        <select
                            id="idServicio"
                            name="idServicio"
                            required
                            class="w-full rounded-lg border border-slate-300 bg-white px-3 py-2.5 text-sm text-slate-700 outline-none transition focus:border-teal-600 focus:ring-2 focus:ring-teal-100"
                        >
                            <option value="">Selecciona un servicio</option>

                            @foreach ($servicios as $servicio)
                                <option
                                    value="{{ $servicio->id }}"
                                    {{ (string) old('idServicio') === (string) $servicio->id ? 'selected' : '' }}
                                >
                                    {{ $servicio->nombre }} ({{ $servicio->duracionMinutos }} min)
                                </option>
                            @endforeach
                        </select>
                    </div>

                </div>

                {{-- Botones --}}
                <div class="flex flex-col-reverse gap-3 border-t border-slate-100 bg-slate-50/70 px-6 py-4 sm:flex-row sm:justify-end">

                    <a
                        href="{{ route('cita.index') }}"
                        class="inline-flex items-center justify-center rounded-lg border border-slate-300 bg-white px-5 py-2.5 text-sm font-semibold text-slate-700 transition hover:bg-slate-100"
                    >
                        Cancelar
                    </a>

                    <button
                        type="submit"
                        class="inline-flex items-center justify-center rounded-lg bg-teal-700 px-5 py-2.5 text-sm font-semibold text-white transition hover:bg-teal-800 focus:outline-none focus:ring-2 focus:ring-teal-500 focus:ring-offset-2"
                    >
                        Registrar cita
                    </button>

                </div>
            </form>
        </div>
    </div>

@endsection