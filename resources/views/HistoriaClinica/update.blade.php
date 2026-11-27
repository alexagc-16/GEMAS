@extends('layouts.app')

@section('title')
    Completar Historia - Gemas
@endsection

@section('content')

    <div class="w-full max-w-5xl mx-auto space-y-6">

        {{-- Encabezado --}}
        <div>
            <h1 class="text-xl sm:text-2xl font-bold text-slate-800">
                Editar historia clínica
            </h1>

            <p class="mt-1 text-sm text-slate-500">
                Actualiza la información médica inicial y los antecedentes de la mascota.
            </p>
        </div>

        {{-- Tarjeta principal --}}
        <div class="overflow-hidden rounded-xl border border-slate-200 bg-white shadow-sm">

            {{-- Encabezado de la tarjeta --}}
            <div class="border-b border-slate-200 px-5 py-4 sm:px-6">

                <div class="flex items-center gap-3">

                    <div class="flex h-11 w-11 items-center justify-center rounded-xl bg-[#EAF4F5] text-[#40899A]">
                        @include('layouts.partials.icons', ['icon' => 'historiaclinica'])
                    </div>

                    <div>
                        <h2 class="text-base font-semibold text-slate-800">
                            Información médica
                        </h2>

                        <p class="mt-0.5 text-xs text-slate-500">
                            Modifica los datos clínicos registrados en la historia.
                        </p>
                    </div>

                </div>

                <p class="mt-3 text-xs text-slate-500">
                    Diligencia la información correspondiente. Si algún dato no aplica,
                    escribe «No presenta» o «Sin antecedentes conocidos».
                </p>

            </div>

            {{-- Errores de validación --}}
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

            <form action="{{ route('historiaclinica.update', $historiaClinica->id) }}"
                method="POST">

                @csrf
                @method('PUT')

                <div class="space-y-8 p-5 sm:p-6">

                    {{-- Datos generales --}}
                    <section>

                        <div class="mb-5">
                            <h3 class="text-sm font-semibold text-slate-800">
                                Datos generales
                            </h3>

                            <p class="mt-1 text-xs text-slate-500">
                                Información de identificación de la historia clínica.
                            </p>
                        </div>

                        <div class="grid grid-cols-1 gap-5 md:grid-cols-2">

                            {{-- Mascota --}}
                            <div>
                                <label for="idMascota"
                                    class="mb-2 block text-sm font-medium text-slate-700">
                                    Mascota <span class="text-red-500">*</span>
                                </label>

                                <input
                                    type="text"
                                    id="idMascota"
                                    value="{{ $historiaClinica->Mascota->nombre }}"
                                    disabled
                                    class="w-full rounded-lg border border-slate-300 bg-slate-100 px-3.5 py-2.5 text-sm text-slate-600 cursor-not-allowed">
                            </div>

                            {{-- Fecha de apertura --}}
                            <div>
                                <label for="fechaApertura"
                                    class="mb-2 block text-sm font-medium text-slate-700">
                                    Fecha de apertura <span class="text-red-500">*</span>
                                </label>

                                <input
                                    type="date"
                                    id="fechaApertura"
                                    value="{{ $historiaClinica->fechaApertura->format('Y-m-d') }}"
                                    disabled
                                    class="w-full rounded-lg border border-slate-300 bg-slate-100 px-3.5 py-2.5 text-sm text-slate-600 cursor-not-allowed">
                            </div>

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
                                Actualiza la información médica previa de la mascota.
                            </p>
                        </div>

                        <div class="grid grid-cols-1 gap-5 md:grid-cols-2">

                            {{-- Antecedentes --}}
                            <div>
                                <label for="antecedentes"
                                    class="mb-2 block text-sm font-medium text-slate-700">
                                    Antecedentes <span class="text-red-500">*</span>
                                </label>

                                <textarea
                                    name="antecedentes"
                                    id="antecedentes"
                                    rows="4"
                                    placeholder="Describe los antecedentes de la mascota..."
                                    class="w-full rounded-lg border border-slate-300 bg-white px-3.5 py-2.5 text-sm text-slate-700 placeholder:text-slate-400 resize-y outline-none transition focus:border-[#40899A] focus:ring-2 focus:ring-[#40899A]/20"
                                >{{ old('antecedentes', $historiaClinica->antecedentes) }}</textarea>
                            </div>

                            {{-- Alergias --}}
                            <div>
                                <label for="alergias"
                                    class="mb-2 block text-sm font-medium text-slate-700">
                                    Alergias <span class="text-red-500">*</span>
                                </label>

                                <textarea
                                    name="alergias"
                                    id="alergias"
                                    rows="4"
                                    placeholder="Indica las alergias conocidas..."
                                    class="w-full rounded-lg border border-slate-300 bg-white px-3.5 py-2.5 text-sm text-slate-700 placeholder:text-slate-400 resize-y outline-none transition focus:border-[#40899A] focus:ring-2 focus:ring-[#40899A]/20"
                                >{{ old('alergias', $historiaClinica->alergias) }}</textarea>
                            </div>

                            {{-- Enfermedades previas --}}
                            <div class="md:col-span-2">

                                <label for="enfermedadesPrevias"
                                    class="mb-2 block text-sm font-medium text-slate-700">
                                    Enfermedades previas <span class="text-red-500">*</span>
                                </label>

                                <textarea
                                    name="enfermedadesPrevias"
                                    id="enfermedadesPrevias"
                                    rows="4"
                                    placeholder="Describe las enfermedades que ha presentado la mascota..."
                                    class="w-full rounded-lg border border-slate-300 bg-white px-3.5 py-2.5 text-sm text-slate-700 placeholder:text-slate-400 resize-y outline-none transition focus:border-[#40899A] focus:ring-2 focus:ring-[#40899A]/20"
                                >{{ old('enfermedadesPrevias', $historiaClinica->enfermedadesPrevias) }}</textarea>

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
                                Actualiza la información adicional del historial médico.
                            </p>
                        </div>

                        <div>

                            <label for="observaciones"
                                class="mb-2 block text-sm font-medium text-slate-700">
                                Observaciones generales <span class="text-red-500">*</span>
                            </label>

                            <textarea
                                name="observaciones"
                                id="observaciones"
                                rows="4"
                                placeholder="Escribe aquí las observaciones..."
                                class="w-full rounded-lg border border-slate-300 bg-white px-3.5 py-2.5 text-sm text-slate-700 placeholder:text-slate-400 resize-y outline-none transition focus:border-[#40899A] focus:ring-2 focus:ring-[#40899A]/20"
                            >{{ old('observaciones', $historiaClinica->observaciones) }}</textarea>

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

                        Guardar cambios
                    </button>

                </div>

            </form>

        </div>

    </div>

@endsection
