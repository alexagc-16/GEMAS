@extends('layouts.app')

@section('title', 'Gemas')
@section('page-title', '')

@section('content')

    <div class="w-full min-w-0 space-y-5">

        {{-- Encabezado --}}
        <div class="flex flex-wrap items-center justify-between gap-3">

            <div>
                <h1 class="text-xl sm:text-2xl font-bold text-slate-800">
                    ¡Bienvenido, Dr. {{ auth()->user()->nombre }}!
                </h1>

                <p class="mt-1 text-sm text-slate-500">
                    Aquí tienes un resumen de tu actividad como veterinario.
                </p>
            </div>

            <div class="hidden sm:flex items-center gap-2 rounded-xl
                        bg-white border border-slate-200 px-4 py-2 shadow-sm">

                <span class="text-sm text-slate-500">
                    Fecha:
                </span>

                <span class="text-sm font-semibold text-slate-700">
                    {{ now()->format('d/m/Y') }}
                </span>

            </div>

        </div>

        {{-- Tarjetas estadísticas --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-4 gap-4">

            <x-stat-card
                label="Citas de hoy"
                :value="number_format($citasHoy)"
                icon="cita"
            />

            {{-- Especialidad --}}
            <div class="bg-white rounded-xl border border-slate-200 shadow-sm p-5">
                <div class="flex items-center justify-between gap-3">

                    <div class="min-w-0">
                        <p class="text-sm font-medium text-slate-500">
                            Especialidad
                        </p>

                        <p class="text-base font-bold text-slate-800 mt-2 truncate">
                            {{ $especialidad ?: 'Sin especialidad' }}
                        </p>
                    </div>

                    <div class="w-11 h-11 shrink-0 rounded-xl bg-primary-50
                                text-primary-700 flex items-center justify-center">

                        @include('layouts.partials.icons', ['icon' => 'veterinario'])

                    </div>

                </div>
            </div>

            <x-stat-card
                label="Historias pendientes"
                :value="number_format($historiasPendientes)"
                icon="historiaclinica"
            />

            <x-stat-card
                label="Citas del mes"
                :value="number_format($totalCitasMes)"
                icon="horario"
            />

        </div>

        
        {{-- Historias pendientes y actividad del veterinario --}}
        <div class="grid grid-cols-1 xl:grid-cols-2 gap-5">

            {{-- Historias clínicas pendientes --}}
            <section class="min-w-0 bg-white rounded-xl border border-slate-200 shadow-sm overflow-hidden">

                <div class="px-5 py-4 border-b border-slate-200">

                    <h2 class="font-semibold text-slate-800">
                        Historias clínicas pendientes por completar
                    </h2>

                    <p class="text-xs text-slate-500 mt-1">
                        Mascotas cuyas historias clínicas necesitan ser completadas.
                    </p>

                </div>

                <div class="overflow-x-auto">

                    <table class="w-full text-sm text-left">

                        <thead class="bg-slate-50 text-slate-500">

                            <tr>
                                <th class="px-4 py-3 font-medium">Mascota</th>
                                <th class="px-4 py-3 font-medium">Fecha de registro</th>
                                <th class="px-4 py-3 font-medium text-center">Acción</th>
                            </tr>

                        </thead>

                        <tbody class="divide-y divide-slate-100">

                            @forelse($listadoHistoriasPendientes as $historia)

                                <tr class="hover:bg-slate-50">

                                    <td class="px-4 py-3 font-medium text-slate-800">
                                        {{ $historia->mascota }}
                                    </td>

                                    <td class="px-4 py-3 whitespace-nowrap text-slate-600">
                                        {{ \Carbon\Carbon::parse($historia->fechaApertura)->format('d/m/Y') }}
                                    </td>

                                    <td class="px-4 py-3 text-center">

                                        <a href="{{ route('historiaclinica.edit', $historia->id) }}"
                                        class="inline-flex items-center justify-center rounded-lg
                                        bg-primary-50 text-primary-700 px-3 py-1.5
                                        text-xs font-semibold hover:bg-primary-100 transition">

                                            Completar

                                        </a>

                                    </td>

                                </tr>

                            @empty

                                <tr>
                                    <td colspan="3" class="px-4 py-8 text-center text-slate-500">
                                        No hay historias clínicas pendientes por completar.
                                    </td>
                                </tr>

                            @endforelse

                        </tbody>

                    </table>

                </div>

            </section>


            {{-- Actividad del veterinario --}}
            <section class="min-w-0 bg-white rounded-xl border border-slate-200 shadow-sm overflow-hidden">

                <div class="px-5 py-4 border-b border-slate-200">

                    <h2 class="font-semibold text-slate-800">
                        Actividad del veterinario
                    </h2>

                    <p class="text-xs text-slate-500 mt-1">
                        Distribución de tus citas según su estado.
                    </p>

                </div>

                <div class="p-6">

                    @php
                        $coloresEstados = [
                            'Confirmada' => [
                                'barra' => 'bg-[#438195]',
                                'punto' => 'bg-[#438195]',
                                'fondo' => 'bg-[#EAF4F5]',
                                'texto' => 'text-[#306174]',
                            ],
                            'En atención' => [
                                'barra' => 'bg-sky-500',
                                'punto' => 'bg-sky-500',
                                'fondo' => 'bg-sky-50',
                                'texto' => 'text-sky-700',
                            ],
                            'Atendida' => [
                                'barra' => 'bg-emerald-500',
                                'punto' => 'bg-emerald-500',
                                'fondo' => 'bg-emerald-50',
                                'texto' => 'text-emerald-700',
                            ],
                            'Cancelada' => [
                                'barra' => 'bg-rose-500',
                                'punto' => 'bg-rose-500',
                                'fondo' => 'bg-rose-50',
                                'texto' => 'text-rose-700',
                            ],
                            'No asistió' => [
                                'barra' => 'bg-amber-500',
                                'punto' => 'bg-amber-500',
                                'fondo' => 'bg-amber-50',
                                'texto' => 'text-amber-700',
                            ],
                        ];
                    @endphp

                    @forelse($actividadVeterinario as $actividad)

                        @php
                            $colorEstado = $coloresEstados[$actividad['nombre']];
                        @endphp

                        <div class="mb-6 last:mb-0">

                            <div class="flex items-center justify-between gap-3 mb-3">

                                <div class="flex items-center gap-2 min-w-0">

                                    <span class="w-2.5 h-2.5 shrink-0 rounded-full
                                        {{ $colorEstado['punto'] }}">
                                    </span>

                                    <span class="inline-flex items-center rounded-lg
                                        px-2.5 py-1 text-sm font-medium
                                        {{ $colorEstado['fondo'] }}
                                        {{ $colorEstado['texto'] }}">

                                        {{ $actividad['nombre'] }}

                                    </span>

                                </div>

                                <span class="text-sm font-semibold text-slate-800 whitespace-nowrap">
                                    {{ number_format($actividad['porcentaje'], 1, ',', '.') }}%
                                </span>

                            </div>

                            <div class="h-2.5 w-full overflow-hidden rounded-full bg-slate-100">

                                <div
                                    class="h-full rounded-full transition-all duration-500
                                        {{ $colorEstado['barra'] }}"
                                    style="width: {{ $actividad['porcentaje'] }}%">
                                </div>

                            </div>

                            <p class="mt-2 text-xs text-slate-500">
                                {{ $actividad['total'] }}
                                {{ $actividad['total'] === 1 ? 'cita registrada' : 'citas registradas' }}
                            </p>

                        </div>

                    @empty

                        <div class="py-10 text-center">

                            <p class="text-sm font-medium text-slate-600">
                                No hay citas registradas todavía.
                            </p>

                        </div>

                    @endforelse

                </div>

            </section>

        </div>



    </div>

@endsection

@push('scripts')

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function () {

            const datosCitas = @json(array_values($actividadVeterinario));

            const etiquetasCitas = [
                'Pendientes',
                'Confirmadas',
                'Atendidas',
                'Canceladas'
            ];

            const elementoCitas = document.getElementById('graficaCitasEstado');

            if (elementoCitas) {

                new Chart(elementoCitas, {

                    type: 'doughnut',

                    data: {
                        labels: etiquetasCitas,

                        datasets: [{
                            label: 'Citas',
                            data: datosCitas,

                            backgroundColor: [
                                '#EAB308',
                                '#438195',
                                '#16A34A',
                                '#EF4444'
                            ],

                            borderWidth: 0,
                            hoverOffset: 6
                        }]
                    },

                    options: {
                        responsive: true,
                        maintainAspectRatio: false,

                        plugins: {
                            legend: {
                                position: 'bottom',

                                labels: {
                                    usePointStyle: true,
                                    padding: 20
                                }
                            }
                        },

                        cutout: '65%'
                    }

                });

            }

        });
    </script>

@endpush


