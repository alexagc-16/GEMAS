@extends('layouts.app')

@section('title')
    Completar Historia Clinica - Gemas
@endsection

@section('content')

    <div class="w-full max-w-5xl mx-auto space-y-6">

        {{-- Encabezado --}}
        <div>

            <h1 class="text-xl sm:text-2xl font-bold text-slate-800">
                Completar historia clínica
            </h1>

            <p class="mt-1 text-sm text-slate-500">
                Registra la información médica inicial de una mascota.
            </p>
        </div>

        {{-- Tarjeta principal --}}
        <div class="overflow-hidden rounded-xl border border-slate-200 bg-white shadow-sm">

            {{-- Encabezado de la tarjeta --}}
            <div class="border-b border-slate-200 px-5 py-4 sm:px-6">
                <div class="flex items-center gap-3">

                    <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-[#EAF4F5] text-[#40899A]">
                        <div class="flex h-11 w-11 items-center justify-center rounded-xl bg-[#EAF4F5] text-[#40899A]">
                            @include('layouts.partials.icons', ['icon' => 'mascota'])
                        </div>
                    </div>

                    <div>
                        <h2 class="text-base font-semibold text-slate-800">
                            Información médica
                        </h2>

                        <p class="mt-0.5 text-xs text-slate-500">
                            Completa los datos iniciales del historial médico.
                        </p>
                    </div>

                </div>
            </div>

            {{-- Mensajes de validación --}}
            @if($errors->any())
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
                                Por favor, revisa los siguientes campos:
                            </p>

                            <ul class="mt-2 list-disc space-y-1 pl-5 text-sm text-red-600">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>

                    </div>
                </div>
            @endif

            @if($historiasClinicas->isEmpty())

                {{-- Sin historias pendientes --}}
                <div class="px-5 py-12 text-center sm:px-6">

                    <div class="mx-auto flex h-14 w-14 items-center justify-center rounded-full bg-[#EAF4F5] text-[#40899A]">
                        <svg class="h-7 w-7" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                stroke-width="1.7"
                                d="M9 12l2 2 4-4m5-2v6a2 2 0 01-2 2h-3l-3 3-3-3H6a2 2 0 01-2-2V6a2 2 0 012-2h12a2 2 0 012 2z" />
                        </svg>
                    </div>

                    <h3 class="mt-4 text-base font-semibold text-slate-800">
                        No hay historias clínicas pendientes
                    </h3>

                    <p class="mx-auto mt-2 max-w-md text-sm text-slate-500">
                        Las historias clínicas de las mascotas registradas ya se encuentran completas.
                    </p>

                    <a href="{{ route('historiaclinica.index') }}"
                        class="mt-5 inline-flex items-center justify-center rounded-lg bg-[#40899A] px-5 py-2.5 text-sm font-semibold text-white transition hover:bg-[#347483]">
                        Volver a historias clínicas
                    </a>

                </div>

            @else

                <form id="formHistoriaClinica" action="" method="POST">

                    @csrf
                    @method('PUT')

                    <div class="space-y-8 p-5 sm:p-6">

                        {{-- Selección de mascota --}}
                        <section>

                            <div class="mb-4">
                                <h3 class="text-sm font-semibold text-slate-800">
                                    Selección de mascota
                                </h3>

                                <p class="mt-1 text-xs text-slate-500">
                                    Selecciona la historia clínica que deseas completar.
                                </p>
                            </div>

                            <div class="max-w-xl">

                                <label for="idHistoriaClinica"
                                    class="mb-2 block text-sm font-medium text-slate-700">
                                    Mascota
                                    <span class="text-red-500">*</span>
                                </label>

                                <select id="idHistoriaClinica"
                                    required
                                    class="w-full rounded-lg border border-slate-300 bg-white px-3.5 py-2.5 text-sm text-slate-700 outline-none transition focus:border-[#40899A] focus:ring-2 focus:ring-[#40899A]/20">

                                    <option value="">Selecciona una mascota</option>

                                    @foreach($historiasClinicas as $historia)
                                        <option value="{{ $historia->id }}"
                                            {{ old('idHistoriaClinica') == $historia->id ? 'selected' : '' }}>
                                            {{ $historia->Mascota->nombre ?? 'Mascota sin nombre' }}
                                        </option>
                                    @endforeach

                                </select>

                                <p class="mt-2 text-xs text-slate-500">
                                    Solo se muestran mascotas con historias clínicas pendientes.
                                </p>

                            </div>

                        </section>

                        <div class="border-t border-slate-200"></div>

                        {{-- Antecedentes médicos --}}
                        <section>

                            <div class="mb-5">
                                <h3 class="text-sm font-semibold text-slate-800">
                                    Antecedentes médicos
                                </h3>

                                <p class="mt-1 text-xs text-slate-500">
                                    Registra la información médica previa de la mascota.
                                </p>
                            </div>

                            <div class="grid grid-cols-1 gap-5 md:grid-cols-2">

                                {{-- Antecedentes --}}
                                <div>
                                    <label for="antecedentes"
                                        class="mb-2 block text-sm font-medium text-slate-700">
                                        Antecedentes
                                        <span class="text-red-500">*</span>
                                    </label>

                                    <textarea name="antecedentes" id="antecedentes"
                                        rows="4" required
                                        placeholder="Describe los antecedentes de la mascota..."
                                        class="w-full rounded-lg border border-slate-300 px-3.5 py-2.5 text-sm text-slate-700 placeholder:text-slate-400 outline-none transition focus:border-[#40899A] focus:ring-2 focus:ring-[#40899A]/20 resize-y">{{ old('antecedentes') }}</textarea>
                                </div>

                                {{-- Alergias --}}
                                <div>
                                    <label for="alergias"
                                        class="mb-2 block text-sm font-medium text-slate-700">
                                        Alergias
                                        <span class="text-red-500">*</span>
                                    </label>

                                    <textarea name="alergias" id="alergias"
                                        rows="4" required
                                        placeholder="Indica las alergias conocidas..."
                                        class="w-full rounded-lg border border-slate-300 px-3.5 py-2.5 text-sm text-slate-700 placeholder:text-slate-400 outline-none transition focus:border-[#40899A] focus:ring-2 focus:ring-[#40899A]/20 resize-y">{{ old('alergias') }}</textarea>
                                </div>

                                {{-- Enfermedades previas --}}
                                <div class="md:col-span-2">
                                    <label for="enfermedadesPrevias"
                                        class="mb-2 block text-sm font-medium text-slate-700">
                                        Enfermedades previas
                                        <span class="text-red-500">*</span>
                                    </label>

                                    <textarea name="enfermedadesPrevias"
                                        id="enfermedadesPrevias" rows="4" required
                                        placeholder="Describe las enfermedades que ha presentado la mascota..."
                                        class="w-full rounded-lg border border-slate-300 px-3.5 py-2.5 text-sm text-slate-700 placeholder:text-slate-400 outline-none transition focus:border-[#40899A] focus:ring-2 focus:ring-[#40899A]/20 resize-y">{{ old('enfermedadesPrevias') }}</textarea>
                                </div>

                            </div>

                        </section>

                        <div class="border-t border-slate-200"></div>

                        {{-- Observaciones --}}
                        <section>

                            <div class="mb-5">
                                <h3 class="text-sm font-semibold text-slate-800">
                                    Observaciones 
                                </h3>

                                <p class="mt-1 text-xs text-slate-500">
                                    Agrega información adicional relevante para el historial médico.
                                </p>
                            </div>

                            <div>
                                <label for="observaciones"
                                    class="mb-2 block text-sm font-medium text-slate-700">
                                    Observaciones generales
                                    <span class="text-red-500">*</span>
                                </label>

                                <textarea name="observaciones" id="observaciones"
                                    rows="4" required
                                    placeholder="Escribe aquí las observaciones..."
                                    class="w-full rounded-lg border border-slate-300 px-3.5 py-2.5 text-sm text-slate-700 placeholder:text-slate-400 outline-none transition focus:border-[#40899A] focus:ring-2 focus:ring-[#40899A]/20 resize-y">{{ old('observaciones') }}</textarea>
                            </div>

                        </section>

                    </div>

                    {{-- Botones --}}
                    <div class="flex flex-col-reverse gap-3 border-t border-slate-200 bg-slate-50 px-5 py-4 sm:flex-row sm:justify-end sm:px-6">

                        <a href="{{ route('historiaclinica.index') }}"
                            class="inline-flex items-center justify-center rounded-lg border border-slate-300 bg-white px-5 py-2.5 text-sm font-medium text-slate-600 transition hover:bg-slate-100">
                            Cancelar
                        </a>

                        <button type="submit"
                            class="inline-flex items-center justify-center gap-2 rounded-lg bg-[#40899A] px-5 py-2.5 text-sm font-semibold text-white transition hover:bg-[#347483]">

                            Completar historia clínica
                        </button>

                    </div>

                </form>

            @endif

        </div>

    </div>

    {{-- Actualizar ruta según la historia clínica seleccionada --}}
    @if(!$historiasClinicas->isEmpty())
        <script>
            document.addEventListener('DOMContentLoaded', function () {

                const selectorHistoria = document.getElementById('idHistoriaClinica');
                const formularioHistoria = document.getElementById('formHistoriaClinica');

                const rutaActualizacion = @json(
                    route('historiaclinica.update', ['historiaclinica' => '__ID__'])
                );

                function actualizarRutaHistoria() {

                    const idHistoria = selectorHistoria.value;

                    formularioHistoria.action = idHistoria
                        ? rutaActualizacion.replace('__ID__', idHistoria)
                        : '';
                }

                selectorHistoria.addEventListener('change', actualizarRutaHistoria);

                actualizarRutaHistoria();

            });
        </script>
    @endif

@endsection
