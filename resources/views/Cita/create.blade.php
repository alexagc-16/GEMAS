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

                    {{-- Fecha y horario --}}
                    <div>
                        <h4 class="mb-4 text-sm font-semibold text-slate-700">
                            Fecha y horario
                        </h4>

                        <div class="grid grid-cols-1 gap-5 sm:grid-cols-2">

                            {{-- Fecha --}}
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

                            {{-- Hora --}}
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
                                    disabled
                                    class="w-full rounded-lg border border-slate-300 bg-slate-100 px-3 py-2.5 text-sm text-slate-700 outline-none transition focus:border-teal-600 focus:ring-2 focus:ring-teal-100 disabled:cursor-not-allowed"
                                >
                            </div>

                        </div>

                        {{-- Horario de atención --}}
                        <div class="mt-5">
                            <p class="mb-2 text-sm font-medium text-slate-700">
                                Horario de atención del día
                            </p>

                            <div
                                id="horarioInfo"
                                class="flex items-center gap-3 rounded-xl border border-slate-200 bg-slate-50 p-4"
                            >
                                <div class="flex h-10 w-10 items-center justify-center rounded-lg bg-slate-200 text-slate-500">
                                    @include('layouts.partials.icons', ['icon' => 'horario'])
                                </div>

                                <div>
                                    <p id="horarioTexto" class="text-sm font-medium text-slate-600">
                                        Selecciona un veterinario y una fecha.
                                    </p>

                                    <p id="diaTexto" class="mt-1 text-xs text-slate-500"></p>
                                </div>
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

    
    {{-- Horarios de los veterinarios --}}
    @php
        $horariosVeterinarios = $veterinarios->mapWithKeys(function ($veterinario) {
            return [
                $veterinario->id => $veterinario->Horario->map(function ($horario) {
                    return [
                        'diaSemana' => $horario->diaSemana,
                        'horaInicio' => $horario->horaInicio,
                        'horaFin' => $horario->horaFin,
                        'horaAlmuerzoInicio' => $horario->horaAlmuerzoInicio,
                        'horaAlmuerzoFin' => $horario->horaAlmuerzoFin,
                    ];
                })->values()
            ];
        });
    @endphp

    <script>
        const horariosVeterinarios = @json($horariosVeterinarios);

        const veterinarioSelect = document.getElementById('idVeterinario');
        const fechaInput = document.getElementById('fecha');
        const horaInput = document.getElementById('hora');

        const horarioTexto = document.getElementById('horarioTexto');
        const diaTexto = document.getElementById('diaTexto');
        const horarioInfo = document.getElementById('horarioInfo');

        const diasSemana = [
            'domingo',
            'lunes',
            'martes',
            'miércoles',
            'jueves',
            'viernes',
            'sábado'
        ];

        function formatoHora(hora) {
            if (!hora) return '';

            const [horas, minutos] = hora.substring(0, 5).split(':');

            const fecha = new Date();
            fecha.setHours(Number(horas), Number(minutos), 0);

            return fecha.toLocaleTimeString('es-CO', {
                hour: '2-digit',
                minute: '2-digit',
                hour12: true
            }).replace(/\./g, '').toUpperCase();
        }

        function normalizarDia(dia) {
            return String(dia)
                .trim()
                .toLowerCase()
                .normalize('NFD')
                .replace(/[\u0300-\u036f]/g, '');
        }

        function mostrarHorario() {
            const idVeterinario = veterinarioSelect.value;
            const fechaSeleccionada = fechaInput.value;

            horaInput.disabled = true;
            horaInput.value = '';
            horaInput.removeAttribute('min');
            horaInput.removeAttribute('max');

            if (!idVeterinario || !fechaSeleccionada) {
                horarioTexto.textContent =
                    'Selecciona un veterinario y una fecha.';

                diaTexto.textContent = '';

                horarioInfo.className =
                    'flex items-center gap-3 rounded-xl border border-slate-200 bg-slate-50 p-4';

                return;
            }

            const [anio, mes, dia] = fechaSeleccionada.split('-').map(Number);
            const fecha = new Date(anio, mes - 1, dia);

            const diaSemana = diasSemana[fecha.getDay()];
            const diaNormalizado = normalizarDia(diaSemana);

            const horarios = horariosVeterinarios[idVeterinario] || [];

            const horariosDelDia = horarios.filter(horario =>
                normalizarDia(horario.diaSemana) === diaNormalizado
            );

            diaTexto.textContent =
                fecha.toLocaleDateString('es-CO', {
                    weekday: 'long',
                    day: 'numeric',
                    month: 'long',
                    year: 'numeric'
                });

            if (horariosDelDia.length === 0) {
                horarioTexto.textContent = 'No hay horario disponible.';

                horarioInfo.className =
                    'flex items-center gap-3 rounded-xl border border-amber-200 bg-amber-50 p-4';

                diaTexto.textContent +=
                    ' · El veterinario no atiende este día.';

                return;
            }

            const rangos = horariosDelDia.map(horario =>
                `${formatoHora(horario.horaInicio)} - ${formatoHora(horario.horaFin)}`
            );

            horarioTexto.textContent = rangos.join(' | ');

            const primerHorario = horariosDelDia[0];

            horaInput.min = primerHorario.horaInicio.substring(0, 5);
            horaInput.max = primerHorario.horaFin.substring(0, 5);
            horaInput.disabled = false;

            horarioInfo.className =
                'flex items-center gap-3 rounded-xl border border-[#C0E0E6] bg-[#EEF6F8] p-4';
        }

        veterinarioSelect.addEventListener('change', mostrarHorario);
        fechaInput.addEventListener('change', mostrarHorario);

        mostrarHorario();
    </script>

@endsection
