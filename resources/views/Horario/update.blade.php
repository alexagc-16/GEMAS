@extends('layouts.app')

@section('title')
    Editar horario - Gemas
@endsection

@section('content')

    <div class="w-full max-w-3xl mx-auto space-y-6">

        {{-- Encabezado --}}
        <div>
            <h1 class="text-2xl font-bold text-slate-800">
                Actualizar horario
            </h1>

            <p class="mt-1 text-sm text-slate-500">
                Modifica la jornada laboral y el horario de almuerzo del veterinario.
            </p>
        </div>

        {{-- Errores --}}
        @if($errors->any())

            <div class="rounded-lg border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-700">

                <p class="mb-2 font-semibold">
                    Revisa los siguientes campos:
                </p>

                <ul class="list-inside list-disc space-y-1">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>

            </div>

        @endif

        {{-- Formulario --}}
        <div class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">

            <div class="p-5 sm:p-6">

                {{-- Encabezado de la tarjeta --}}
                <div class="flex items-center gap-4 border-b border-slate-100 pb-5">

                    <div class="flex h-12 w-12 flex-shrink-0 items-center
                                justify-center rounded-xl bg-[#EAF4F5] text-[#40899A]">

                        @include('layouts.partials.icons', [
                            'icon' => 'horario'
                        ])

                    </div>

                    <div>
                        <h2 class="text-lg font-semibold text-slate-800">
                            Información del horario
                        </h2>

                        <p class="text-sm text-slate-500">
                            Actualiza los datos de la jornada del veterinario.
                        </p>
                    </div>

                </div>

                <form action="{{ route('horario.update', $horario->id) }}"
                    method="POST"
                    class="mt-6 space-y-6">

                    @csrf
                    @method('PUT')

                    {{-- Jornada laboral --}}
                    <div class="space-y-5">

                        <div>
                            <h3 class="text-base font-semibold text-slate-800">
                                Jornada laboral
                            </h3>

                            <p class="mt-1 text-sm text-slate-500">
                                Modifica el día y las horas de atención.
                            </p>
                        </div>

                        <div class="grid grid-cols-1 gap-5 sm:grid-cols-2">

                            {{-- Día --}}
                            <div class="sm:col-span-2">

                                <label for="diaSemana"
                                    class="mb-2 block text-sm font-medium text-slate-700">
                                    Día de la semana <span class="text-red-500">*</span>
                                </label>

                                <select name="diaSemana" id="diaSemana" required
                                    class="w-full rounded-lg border border-slate-300
                                           px-3 py-2.5 text-sm text-slate-800
                                           outline-none transition
                                           focus:border-[#40899A]
                                           focus:ring-2 focus:ring-[#40899A]/20">

                                    <option value="">Selecciona un día</option>

                                    @foreach ([
                                        'Lunes',
                                        'Martes',
                                        'Miércoles',
                                        'Jueves',
                                        'Viernes',
                                        'Sábado',
                                        'Domingo'
                                    ] as $dia)

                                        <option value="{{ $dia }}"
                                            {{ old('diaSemana', $horario->diaSemana) == $dia ? 'selected' : '' }}>
                                            {{ $dia }}
                                        </option>

                                    @endforeach

                                </select>

                            </div>

                            {{-- Inicio --}}
                            <div>

                                <label for="horaInicio"
                                    class="mb-2 block text-sm font-medium text-slate-700">
                                    Hora de inicio <span class="text-red-500">*</span>
                                </label>

                                <input type="time"
                                    name="horaInicio"
                                    id="horaInicio"
                                    value="{{ old('horaInicio', $horario->horaInicio ? substr($horario->horaInicio, 0, 5) : '') }}"
                                    required
                                    class="w-full rounded-lg border border-slate-300
                                           px-3 py-2.5 text-sm text-slate-800
                                           outline-none transition
                                           focus:border-[#40899A]
                                           focus:ring-2 focus:ring-[#40899A]/20">

                            </div>

                            {{-- Fin --}}
                            <div>

                                <label for="horaFin"
                                    class="mb-2 block text-sm font-medium text-slate-700">
                                    Hora de finalización <span class="text-red-500">*</span>
                                </label>

                                <input type="time"
                                    name="horaFin"
                                    id="horaFin"
                                    value="{{ old('horaFin', $horario->horaFin ? substr($horario->horaFin, 0, 5) : '') }}"
                                    required
                                    class="w-full rounded-lg border border-slate-300
                                           px-3 py-2.5 text-sm text-slate-800
                                           outline-none transition
                                           focus:border-[#40899A]
                                           focus:ring-2 focus:ring-[#40899A]/20">

                            </div>

                        </div>

                    </div>

                    {{-- Almuerzo --}}
                    <div class="space-y-5 border-t border-slate-100 pt-6">

                        <div>
                            <h3 class="text-base font-semibold text-slate-800">
                                Horario de almuerzo
                            </h3>

                            <p class="mt-1 text-sm text-slate-500">
                                Define el intervalo en el que el veterinario no estará disponible.
                            </p>
                        </div>

                        <div class="grid grid-cols-1 gap-5 sm:grid-cols-2">

                            {{-- Inicio almuerzo --}}
                            <div>

                                <label for="horaAlmuerzoInicio"
                                    class="mb-2 block text-sm font-medium text-slate-700">
                                    Inicio del almuerzo
                                </label>

                                <input type="time"
                                    name="horaAlmuerzoInicio"
                                    id="horaAlmuerzoInicio"
                                    value="{{ old('horaAlmuerzoInicio', $horario->horaAlmuerzoInicio ? substr($horario->horaAlmuerzoInicio, 0, 5) : '') }}"
                                    class="w-full rounded-lg border border-slate-300
                                           px-3 py-2.5 text-sm text-slate-800
                                           outline-none transition
                                           focus:border-[#40899A]
                                           focus:ring-2 focus:ring-[#40899A]/20">

                            </div>

                            {{-- Fin almuerzo --}}
                            <div>

                                <label for="horaAlmuerzoFin"
                                    class="mb-2 block text-sm font-medium text-slate-700">
                                    Finalización del almuerzo
                                </label>

                                <input type="time"
                                    name="horaAlmuerzoFin"
                                    id="horaAlmuerzoFin"
                                    value="{{ old('horaAlmuerzoFin', $horario->horaAlmuerzoFin ? substr($horario->horaAlmuerzoFin, 0, 5) : '') }}"
                                    class="w-full rounded-lg border border-slate-300
                                           px-3 py-2.5 text-sm text-slate-800
                                           outline-none transition
                                           focus:border-[#40899A]
                                           focus:ring-2 focus:ring-[#40899A]/20">

                            </div>

                        </div>

                        <p class="text-xs text-slate-400">
                            Si el veterinario no tiene un horario de almuerzo definido,
                            puedes dejar ambos campos vacíos.
                        </p>

                    </div>

                    {{-- Veterinario --}}
                    <div class="border-t border-slate-100 pt-6">

                        <label for="idVeterinario"
                            class="mb-2 block text-sm font-medium text-slate-700">
                            Veterinario <span class="text-red-500">*</span>
                        </label>

                        <select name="idVeterinario" id="idVeterinario" required
                            class="w-full rounded-lg border border-slate-300
                                   px-3 py-2.5 text-sm text-slate-800
                                   outline-none transition
                                   focus:border-[#40899A]
                                   focus:ring-2 focus:ring-[#40899A]/20">

                            <option value="">Selecciona un veterinario</option>

                            @foreach ($veterinarios as $veterinario)

                                <option value="{{ $veterinario->id }}"
                                    {{ old('idVeterinario', $horario->idVeterinario) == $veterinario->id ? 'selected' : '' }}>
                                    {{ $veterinario->nombre }}
                                </option>

                            @endforeach

                        </select>

                    </div>

                    {{-- Botones --}}
                    <div class="flex flex-col-reverse justify-end gap-3
                                border-t border-slate-100 pt-5 sm:flex-row">

                        <a href="{{ route('horario.index') }}"
                            class="inline-flex items-center justify-center rounded-lg
                                   border border-slate-300 px-5 py-2.5 text-sm
                                   font-semibold text-slate-700
                                   hover:bg-slate-50 transition">

                            Cancelar

                        </a>

                        <button type="submit"
                            class="inline-flex items-center justify-center gap-2
                                   rounded-lg bg-[#40899A] px-5 py-2.5
                                   text-sm font-semibold text-white
                                   hover:bg-[#347787] transition">

                            Actualizar horario

                        </button>

                    </div>

                </form>

            </div>

        </div>

    </div>

@endsection
