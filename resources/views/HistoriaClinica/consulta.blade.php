
@extends('layouts.app')

@section('title')
    Atención veterinaria - GEMAS
@endsection

@section('content')

    <div class="mx-auto w-full max-w-5xl space-y-6">

        {{-- Encabezado --}}
        <div>
            <a href="{{ route('cita.index') }}"
                class="mb-3 inline-flex items-center gap-2 text-sm font-medium
                    text-slate-500 transition hover:text-[#40899A]">

                <svg class="h-4 w-4" fill="none" stroke="currentColor"
                    viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        stroke-width="2" d="m15 18-6-6 6-6"/>
                </svg>

                Volver a citas
            </a>

            <div>
                <h1 class="text-2xl font-bold text-slate-800">
                    Atención veterinaria
                </h1>

                <p class="mt-1 text-sm text-slate-500">
                    Registra la evolución clínica y los diagnósticos de la mascota. Si no se requiere alguno, escribe «Ninguno».
                </p>
            </div>
        </div>

        {{-- Errores de validación --}}
        @if ($errors->any())
            <div class="rounded-xl border border-red-200 bg-red-50 p-4">

                <div class="flex items-start gap-3">

                    <svg class="mt-0.5 h-5 w-5 shrink-0 text-red-500"
                        fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            stroke-width="2"
                            d="M12 9v4m0 4h.01M10.3 3.9 1.8 18a2 2 0 0 0 1.7 3h17a2 2 0 0 0 1.7-3L13.7 3.9a2 2 0 0 0-3.4 0Z"/>
                    </svg>

                    <div>
                        <p class="text-sm font-semibold text-red-700">
                            Revisa los siguientes campos:
                        </p>

                        <ul class="mt-2 list-inside list-disc space-y-1 text-sm text-red-600">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>

                </div>
            </div>
        @endif

        {{-- Información de la cita --}}
        <div class="overflow-hidden rounded-xl border border-slate-200 bg-white shadow-sm">

            <div class="flex items-center gap-3 border-b border-slate-100 px-5 py-4 sm:px-6">

                <div class="flex h-10 w-10 shrink-0 items-center justify-center
                            rounded-xl bg-[#EAF4F5] text-[#40899A]">

                    <div class="flex h-11 w-11 items-center justify-center rounded-xl bg-[#EAF4F5] text-slate-700">
                        @include('layouts.partials.icons', ['icon' => 'cita'])
                    </div>
                </div>

                <div>
                    <h2 class="text-base font-semibold text-slate-800">
                        Información de la cita
                    </h2>

                    <p class="mt-0.5 text-xs text-slate-500">
                        Datos de la atención programada.
                    </p>
                </div>

            </div>

            <div class="grid grid-cols-1 gap-5 p-5 sm:grid-cols-2 sm:p-6">

                <div>
                    <p class="text-xs font-medium text-slate-500">Mascota</p>
                    <p class="mt-1.5 text-sm font-semibold text-slate-800">
                        {{ $cita->Mascota->nombre ?? 'No disponible' }}
                    </p>
                </div>

                <div>
                    <p class="text-xs font-medium text-slate-500">Veterinario</p>
                    <p class="mt-1.5 text-sm font-semibold text-slate-800">
                        {{ $cita->Veterinario->nombre ?? 'No disponible' }}
                    </p>
                </div>

                <div>
                    <p class="text-xs font-medium text-slate-500">Servicio</p>
                    <p class="mt-1.5 text-sm font-semibold text-slate-800">
                        {{ $cita->Servicio->nombre ?? 'No disponible' }}
                    </p>
                </div>

                <div>
                    <p class="text-xs font-medium text-slate-500">Fecha de la cita</p>
                    <p class="mt-1.5 text-sm font-semibold text-slate-800">
                        {{ $cita->fecha }}
                    </p>
                </div>

                <div>
                    <p class="text-xs font-medium text-slate-500">Hora</p>
                    <p class="mt-1.5 text-sm font-semibold text-slate-800">
                        {{ $cita->hora }}
                    </p>
                </div>

                <div>
                    <p class="text-xs font-medium text-slate-500">Estado</p>
                    <div class="mt-1.5">
                        <span class="inline-flex items-center gap-1.5 rounded-full
                                    bg-blue-50 px-3 py-1 text-xs font-semibold text-blue-700">
                            <span class="h-1.5 w-1.5 rounded-full bg-blue-500"></span>
                            {{ $cita->estado }}
                        </span>
                    </div>
                </div>

            </div>
        </div>

        {{-- Historia clínica previa --}}
        <div class="overflow-hidden rounded-xl border border-slate-200 bg-white shadow-sm">

            <div class="flex items-center gap-3 border-b border-slate-100 px-5 py-4 sm:px-6">

                <div class="flex h-10 w-10 shrink-0 items-center justify-center
                            rounded-xl bg-[#EAF4F5] text-[#40899A]">

                    <div class="flex h-11 w-11 items-center justify-center rounded-xl bg-[#EAF4F5] text-slate-700">
                        @include('layouts.partials.icons', ['icon' => 'historiaclinica'])
                    </div>

                </div>

                <div>
                    <h2 class="text-base font-semibold text-slate-800">
                        Antecedentes de la historia clínica
                    </h2>

                    <p class="mt-0.5 text-xs text-slate-500">
                        Información médica registrada anteriormente.
                    </p>
                </div>

            </div>

            <div class="grid grid-cols-1 gap-5 p-5 sm:grid-cols-2 sm:p-6">

                @foreach ([
                    'Antecedentes' => $historiaClinica->antecedentes,
                    'Alergias' => $historiaClinica->alergias,
                    'Enfermedades previas' => $historiaClinica->enfermedadesPrevias,
                    'Observaciones previas' => $historiaClinica->observaciones,
                ] as $titulo => $contenido)

                    <div class="rounded-xl bg-slate-50 p-4">
                        <p class="text-xs font-semibold text-slate-600">
                            {{ $titulo }}
                        </p>

                        <p class="mt-2 whitespace-pre-line break-words text-sm
                                leading-relaxed text-slate-500">
                            {{ $contenido ?: 'Sin información registrada' }}
                        </p>
                    </div>

                @endforeach

            </div>
        </div>

        {{-- Formulario de atención --}}
        <form action="{{ route('cita.finalizar', $cita->id) }}"
            method="POST"
            class="space-y-6">

            @csrf

            <input type="hidden" name="accion" value="finalizar_consulta">

            {{-- Evolución clínica --}}
            <div class="overflow-hidden rounded-xl border border-slate-200 bg-white shadow-sm">

                <div class="flex items-center gap-3 border-b border-slate-100 px-5 py-4 sm:px-6">

                    <div class="flex h-10 w-10 shrink-0 items-center justify-center
                                rounded-xl bg-[#EAF4F5] text-[#40899A]">

                        <div class="flex h-11 w-11 items-center justify-center rounded-xl bg-[#EAF4F5] text-slate-700">
                            @include('layouts.partials.icons', ['icon' => 'evolucion'])
                        </div>

                    </div>

                    <div>
                        <h2 class="text-base font-semibold text-slate-800">
                            Evolución clínica
                        </h2>

                        <p class="mt-0.5 text-xs text-slate-500">
                            Registra los hallazgos de la atención actual. Si algún dato no aplica, escribe «Ninguno».
                        </p>
                    </div>

                </div>

                <div class="grid grid-cols-1 gap-5 p-5 sm:grid-cols-2 sm:p-6">

                    {{-- Peso --}}
                    <div>
                        <label for="peso" class="mb-2 block text-sm font-medium text-slate-700">
                            Peso (kg) <span class="text-red-500">*</span>
                        </label>

                        <input type="number" step="0.01" min="0.01"
                            name="peso" id="peso"
                            value="{{ old('peso') }}"
                            required
                            placeholder="Ej. 5.50"
                            class="w-full rounded-lg border border-slate-200 bg-slate-50
                                px-3.5 py-2.5 text-sm text-slate-700
                                transition placeholder:text-slate-400
                                focus:border-[#40899A] focus:bg-white
                                focus:outline-none focus:ring-2 focus:ring-[#40899A]/15">
                    </div>

                    {{-- Temperatura --}}
                    <div>
                        <label for="temperatura" class="mb-2 block text-sm font-medium text-slate-700">
                            Temperatura (°C) <span class="text-red-500">*</span>
                        </label>

                        <input type="number" step="any" min="0.01"
                            name="temperatura" id="temperatura"
                            value="{{ old('temperatura') }}"
                            required
                            placeholder="Ej. 38.5"
                            class="w-full rounded-lg border border-slate-200 bg-slate-50
                                px-3.5 py-2.5 text-sm text-slate-700
                                transition placeholder:text-slate-400
                                focus:border-[#40899A] focus:bg-white
                                focus:outline-none focus:ring-2 focus:ring-[#40899A]/15">
                    </div>

                    {{-- Síntomas --}}
                    <div class="sm:col-span-2">
                        <label for="sintomas" class="mb-2 block text-sm font-medium text-slate-700">
                            Síntomas <span class="text-red-500">*</span>
                        </label>

                        <textarea name="sintomas" id="sintomas" rows="3" required
                            placeholder="Describe los síntomas que presenta la mascota..."
                            class="w-full resize-y rounded-lg border border-slate-200
                                bg-slate-50 px-3.5 py-2.5 text-sm text-slate-700
                                transition placeholder:text-slate-400
                                focus:border-[#40899A] focus:bg-white
                                focus:outline-none focus:ring-2 focus:ring-[#40899A]/15">{{ old('sintomas') }}</textarea>
                    </div>

                    {{-- Observaciones --}}
                    <div class="sm:col-span-2">
                        <label for="observaciones" class="mb-2 block text-sm font-medium text-slate-700">
                            Observaciones de la evolución <span class="text-red-500">*</span>
                        </label>

                        <textarea name="observaciones" id="observaciones" rows="3" required
                            placeholder="Registra los hallazgos y observaciones de la consulta..."
                            class="w-full resize-y rounded-lg border border-slate-200
                                bg-slate-50 px-3.5 py-2.5 text-sm text-slate-700
                                transition placeholder:text-slate-400
                                focus:border-[#40899A] focus:bg-white
                                focus:outline-none focus:ring-2 focus:ring-[#40899A]/15">{{ old('observaciones') }}</textarea>
                    </div>

                    {{-- Veterinario --}}
                    <div class="sm:col-span-2">
                        <label for="idVeterinario" class="mb-2 block text-sm font-medium text-slate-700">
                            Veterinario responsable
                        </label>

                        <input type="hidden"
                            name="idVeterinario"
                            value="{{ $cita->idVeterinario }}">

                        <div class="relative">
                            <div class="absolute left-3.5 top-1/2 flex h-5 w-5 -translate-y-1/2 items-center justify-center text-slate-400">
                                @include('layouts.partials.icons', ['icon' => 'veterinario'])
                            </div>

                            <input type="text"
                                id="idVeterinario"
                                value="{{ $cita->Veterinario->nombre ?? 'No disponible' }}"
                                readonly
                                class="w-full rounded-lg border border-slate-200
                                    bg-slate-100 py-2.5 pl-11 pr-4 text-sm
                                    text-slate-600 outline-none">
                        </div>
                    </div>

                </div>
            </div>

            {{-- Diagnósticos y tratamientos --}}
            <div class="overflow-hidden rounded-xl border border-slate-200 bg-white shadow-sm">

                <div class="flex flex-col gap-3 border-b border-slate-100
                            px-5 py-4 sm:flex-row sm:items-center
                            sm:justify-between sm:px-6">

                    <div class="flex items-center gap-3">

                        <div class="flex h-10 w-10 shrink-0 items-center
                                    justify-center rounded-xl bg-[#EAF4F5]
                                    text-[#40899A]">

                            <div class="flex h-11 w-11 items-center justify-center rounded-xl bg-[#EAF4F5] text-slate-700">
                                @include('layouts.partials.icons', ['icon' => 'diagnostico'])
                            </div>

                        </div>

                        <div>
                            <h2 class="text-base font-semibold text-slate-800">
                                Diagnósticos y tratamientos
                            </h2>

                            <p class="mt-0.5 text-xs text-slate-500">
                                    Registra los diagnósticos y tratamientos necesarios. Si no se requiere alguno, escribe «Ninguno».
                            </p>
                        </div>

                    </div>

                    <button type="button" id="agregarDiagnostico"
                        class="inline-flex items-center justify-center gap-2
                            rounded-lg bg-[#40899A] px-4 py-2.5
                            text-sm font-semibold text-white shadow-sm
                            transition hover:bg-[#347787]">

                        <svg class="h-4 w-4" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                stroke-width="2" d="M12 5v14m7-7H5"/>
                        </svg>

                        Agregar diagnóstico
                    </button>

                </div>

                <div id="contenedorDiagnosticos" class="space-y-5 p-5 sm:p-6">

                    {{-- Primer diagnóstico --}}
                    <div class="bloque-diagnostico overflow-hidden rounded-xl
                                border border-slate-200">

                        <div class="flex items-center justify-between gap-3
                                    border-b border-slate-100 bg-slate-50
                                    px-4 py-3">

                            <h3 class="titulo-diagnostico text-sm font-semibold text-slate-700">
                                Registro 1
                            </h3>

                            <button type="button"
                                class="eliminar-diagnostico hidden text-xs
                                    font-semibold text-red-500 transition
                                    hover:text-red-700">
                                Eliminar
                            </button>

                        </div>

                        <div class="grid grid-cols-1 gap-5 p-4 sm:grid-cols-2">

                            {{-- Diagnóstico --}}
                            <div>
                                <label class="mb-2 block text-sm font-medium text-slate-700">
                                    Diagnóstico <span class="text-red-500">*</span>
                                </label>

                                <textarea name="diagnosticos[0][diagnostico]" rows="2"
                                    class="campo-diagnostico w-full rounded-lg
                                        border border-slate-200 bg-slate-50
                                        px-3.5 py-2.5 text-sm text-slate-700
                                        transition focus:border-[#40899A]
                                        focus:bg-white focus:outline-none
                                        focus:ring-2 focus:ring-[#40899A]/15"></textarea>
                            </div>

                            {{-- Tratamiento --}}
                            <div>
                                <label class="mb-2 block text-sm font-medium text-slate-700">
                                    Tratamiento <span class="text-red-500">*</span>
                                </label>

                                <textarea name="diagnosticos[0][tratamiento]" rows="2"
                                    class="campo-diagnostico w-full rounded-lg
                                        border border-slate-200 bg-slate-50
                                        px-3.5 py-2.5 text-sm text-slate-700
                                        transition focus:border-[#40899A]
                                        focus:bg-white focus:outline-none
                                        focus:ring-2 focus:ring-[#40899A]/15"></textarea>
                            </div>

                            {{-- Medicamento --}}
                            <div>
                                <label class="mb-2 block text-sm font-medium text-slate-700">
                                    Medicamento <span class="text-red-500">*</span>
                                </label>

                                <input name="diagnosticos[0][medicamento]" type="text"
                                    class="campo-diagnostico w-full rounded-lg
                                        border border-slate-200 bg-slate-50
                                        px-3.5 py-2.5 text-sm text-slate-700
                                        transition focus:border-[#40899A]
                                        focus:bg-white focus:outline-none
                                        focus:ring-2 focus:ring-[#40899A]/15">
                            </div>

                            {{-- Dosis --}}
                            <div>
                                <label class="mb-2 block text-sm font-medium text-slate-700">
                                    Dosis <span class="text-red-500">*</span>
                                </label>

                                <input name="diagnosticos[0][dosis]" type="text" maxlength="170"
                                    class="campo-diagnostico w-full rounded-lg
                                        border border-slate-200 bg-slate-50
                                        px-3.5 py-2.5 text-sm text-slate-700
                                        transition focus:border-[#40899A]
                                        focus:bg-white focus:outline-none
                                        focus:ring-2 focus:ring-[#40899A]/15">
                            </div>

                            {{-- Frecuencia --}}
                            <div>
                                <label class="mb-2 block text-sm font-medium text-slate-700">
                                    Frecuencia <span class="text-red-500">*</span>
                                </label>

                                <input name="diagnosticos[0][frecuencia]" type="text" maxlength="170"
                                    class="campo-diagnostico w-full rounded-lg
                                        border border-slate-200 bg-slate-50
                                        px-3.5 py-2.5 text-sm text-slate-700
                                        transition focus:border-[#40899A]
                                        focus:bg-white focus:outline-none
                                        focus:ring-2 focus:ring-[#40899A]/15">
                            </div>

                            {{-- Duración --}}
                            <div>
                                <label class="mb-2 block text-sm font-medium text-slate-700">
                                    Duración <span class="text-red-500">*</span>
                                </label>

                                <input name="diagnosticos[0][duracion]" type="text" maxlength="170"
                                    class="campo-diagnostico w-full rounded-lg
                                        border border-slate-200 bg-slate-50
                                        px-3.5 py-2.5 text-sm text-slate-700
                                        transition focus:border-[#40899A]
                                        focus:bg-white focus:outline-none
                                        focus:ring-2 focus:ring-[#40899A]/15">
                            </div>

                            {{-- Procedimiento --}}
                            <div>
                                <label class="mb-2 block text-sm font-medium text-slate-700">
                                    Procedimiento <span class="text-red-500">*</span>
                                </label>

                                <textarea name="diagnosticos[0][procedimiento]" rows="2"
                                    class="campo-diagnostico w-full rounded-lg
                                        border border-slate-200 bg-slate-50
                                        px-3.5 py-2.5 text-sm text-slate-700
                                        transition focus:border-[#40899A]
                                        focus:bg-white focus:outline-none
                                        focus:ring-2 focus:ring-[#40899A]/15"></textarea>
                            </div>

                            {{-- Exámenes --}}
                            <div>
                                <label class="mb-2 block text-sm font-medium text-slate-700">
                                    Exámenes ordenados <span class="text-red-500">*</span>
                                </label>

                                <textarea name="diagnosticos[0][examenOrdenado]" rows="2"
                                    class="campo-diagnostico w-full rounded-lg
                                        border border-slate-200 bg-slate-50
                                        px-3.5 py-2.5 text-sm text-slate-700
                                        transition focus:border-[#40899A]
                                        focus:bg-white focus:outline-none
                                        focus:ring-2 focus:ring-[#40899A]/15"></textarea>
                            </div>

                            {{-- Indicaciones --}}
                            <div class="sm:col-span-2">
                                <label class="mb-2 block text-sm font-medium text-slate-700">
                                    Indicaciones <span class="text-red-500">*</span>
                                </label>

                                <textarea name="diagnosticos[0][indicaciones]" rows="2"
                                    class="campo-diagnostico w-full rounded-lg
                                        border border-slate-200 bg-slate-50
                                        px-3.5 py-2.5 text-sm text-slate-700
                                        transition focus:border-[#40899A]
                                        focus:bg-white focus:outline-none
                                        focus:ring-2 focus:ring-[#40899A]/15"></textarea>
                            </div>

                        </div>
                    </div>

                </div>
            </div>

            {{-- Botones --}}
            <div class="flex flex-col-reverse gap-3 border-t border-slate-200
                        pt-5 sm:flex-row sm:justify-end">

                <a href="{{ route('cita.index') }}"
                    class="inline-flex items-center justify-center gap-2
                        rounded-lg border border-slate-300 bg-white
                        px-5 py-2.5 text-sm font-semibold text-slate-600
                        transition hover:bg-slate-50">

                    Cancelar
                </a>

                <button type="submit"
                    class="inline-flex items-center justify-center gap-2
                        rounded-lg bg-[#40899A] px-5 py-2.5
                        text-sm font-semibold text-white shadow-sm
                        transition hover:bg-[#347787]">

                    Finalizar consulta
                </button>

            </div>

        </form>

    </div>

    {{-- Script para agregar y eliminar diagnósticos --}}
    <script>
        document.addEventListener('DOMContentLoaded', function () {

            const contenedor = document.getElementById('contenedorDiagnosticos');
            const botonAgregar = document.getElementById('agregarDiagnostico');

            if (!contenedor || !botonAgregar) {
                return;
            }

            function actualizarBloques() {

                const bloques = contenedor.querySelectorAll('.bloque-diagnostico');

                bloques.forEach((bloque, indice) => {

                    bloque.querySelector('.titulo-diagnostico').textContent =
                        `Registro ${indice + 1}`;

                    const botonEliminar = bloque.querySelector('.eliminar-diagnostico');

                    botonEliminar.classList.toggle('hidden', bloques.length === 1);

                    bloque.querySelectorAll('[name]').forEach(campo => {

                        campo.name = campo.name.replace(
                            /diagnosticos\[\d+\]/,
                            `diagnosticos[${indice}]`
                        );

                    });

                });

            }

            botonAgregar.addEventListener('click', function () {

                const original = contenedor.querySelector('.bloque-diagnostico');

                if (!original) {
                    return;
                }

                const nuevo = original.cloneNode(true);

                nuevo.querySelectorAll('input, textarea').forEach(campo => {
                    campo.value = '';
                });

                contenedor.appendChild(nuevo);

                actualizarBloques();

            });

            contenedor.addEventListener('click', function (evento) {

                const boton = evento.target.closest('.eliminar-diagnostico');

                if (!boton) {
                    return;
                }

                const bloque = boton.closest('.bloque-diagnostico');

                if (bloque && contenedor.querySelectorAll('.bloque-diagnostico').length > 1) {
                    bloque.remove();
                    actualizarBloques();
                }

            });

            actualizarBloques();

        });
    </script>

@endsection

