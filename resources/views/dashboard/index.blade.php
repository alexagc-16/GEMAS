@extends('layouts.app')

@section('title', 'Gemas')
@section('page-title', '')

@section('content')

    <div class="w-full min-w-0 space-y-5">

        {{-- Encabezado --}}
        <div class="flex flex-wrap items-center justify-between gap-3">
            <div>
                <h1 class="text-xl sm:text-2xl font-bold text-slate-800">
                    ¡Bienvenido, Administrador!
                </h1>
                <p class="mt-1 text-sm text-slate-500">
                    Aquí tienes un resumen de la actividad de la clínica veterinaria.
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
                label="Mascotas registradas"
                :value="number_format($totalMascotas)"
                icon="mascota"
            />

            <x-stat-card
                label="Usuarios registrados"
                :value="number_format($totalUsuarios)"
                icon="usuario"
            />

            <x-stat-card
                label="Citas de hoy"
                :value="number_format($citasHoy)"
                icon="cita"
            />

            <x-stat-card
                label="Citas del mes"
                :value="number_format($totalCitasMes)"
                icon="horario"
            />

        </div>

        {{-- Accesos rápidos y próximas citas --}}
        <div class="grid grid-cols-1 2xl:grid-cols-2 gap-5">

            {{-- Accesos rápidos --}}
            <section class="min-w-0 bg-white rounded-xl border border-slate-200 shadow-sm overflow-hidden">

                <div class="px-5 py-4 border-b border-slate-200">
                    <h2 class="font-semibold text-slate-800">
                        Accesos rápidos
                    </h2>

                    <p class="text-xs text-slate-500 mt-1">
                        Accede fácilmente a las principales funciones
                    </p>
                </div>

                <div class="p-5 grid grid-cols-1 sm:grid-cols-2 gap-4">

                    {{-- Usuarios --}}
                    @if(Route::has('usuario.index'))
                        <a href="{{ route('usuario.index') }}"
                            class="group flex items-center gap-3 p-4 rounded-xl
                            border border-slate-200 bg-slate-50
                            hover:bg-primary-50 hover:border-primary-200
                            transition-all duration-200">

                            <div class="w-11 h-11 shrink-0 rounded-xl bg-blue-100
                                text-blue-700 flex items-center justify-center">
                                @include('layouts.partials.icons', ['icon' => 'usuario'])
                            </div>

                            <div class="min-w-0">
                                <p class="text-sm font-semibold text-slate-800">
                                    Usuarios
                                </p>
                                <p class="text-xs text-slate-500 mt-1">
                                    Gestionar propietarios
                                </p>
                            </div>
                        </a>
                    @endif

                    {{-- Mascotas --}}
                    @if(Route::has('mascota.index'))
                        <a href="{{ route('mascota.index') }}"
                            class="group flex items-center gap-3 p-4 rounded-xl
                            border border-slate-200 bg-slate-50
                            hover:bg-primary-50 hover:border-primary-200
                            transition-all duration-200">

                            <div class="w-11 h-11 shrink-0 rounded-xl bg-emerald-100
                                text-emerald-700 flex items-center justify-center">
                                @include('layouts.partials.icons', ['icon' => 'mascota'])
                            </div>

                            <div class="min-w-0">
                                <p class="text-sm font-semibold text-slate-800">
                                    Mascotas
                                </p>
                                <p class="text-xs text-slate-500 mt-1">
                                    Consultar registros
                                </p>
                            </div>
                        </a>
                    @endif

                    {{-- Citas --}}
                    @if(Route::has('cita.index'))
                        <a href="{{ route('cita.index') }}"
                            class="group flex items-center gap-3 p-4 rounded-xl
                            border border-slate-200 bg-slate-50
                            hover:bg-primary-50 hover:border-primary-200
                            transition-all duration-200">

                            <div class="w-11 h-11 shrink-0 rounded-xl bg-violet-100
                                text-violet-700 flex items-center justify-center">
                                @include('layouts.partials.icons', ['icon' => 'cita'])
                            </div>

                            <div class="min-w-0">
                                <p class="text-sm font-semibold text-slate-800">
                                    Citas
                                </p>
                                <p class="text-xs text-slate-500 mt-1">
                                    Administrar citas
                                </p>
                            </div>
                        </a>
                    @endif

                    {{-- Servicios --}}
                    @if(Route::has('servicio.index'))
                        <a href="{{ route('servicio.index') }}"
                            class="group flex items-center gap-3 p-4 rounded-xl
                            border border-slate-200 bg-slate-50
                            hover:bg-primary-50 hover:border-primary-200
                            transition-all duration-200">

                            <div class="w-11 h-11 shrink-0 rounded-xl bg-amber-100
                                text-amber-700 flex items-center justify-center">
                                @include('layouts.partials.icons', ['icon' => 'servicio'])
                            </div>

                            <div class="min-w-0">
                                <p class="text-sm font-semibold text-slate-800">
                                    Servicios
                                </p>
                                <p class="text-xs text-slate-500 mt-1">
                                    Gestionar servicios
                                </p>
                            </div>
                        </a>
                    @endif

                </div>
            </section>

            {{-- Próximas citas --}}
            <section class="min-w-0 bg-white rounded-xl border
                            border-slate-200 shadow-sm overflow-hidden">

                <div class="flex items-center justify-between gap-3
                            px-5 py-4 border-b border-slate-200">
                    <div>
                        <h2 class="font-semibold text-slate-800">
                            Próximas citas
                        </h2>
                        <p class="text-xs text-slate-500 mt-1">
                            Citas de los próximos días
                        </p>
                    </div>

                    <a href="{{ route('cita.index') }}"
                    class="shrink-0 text-sm font-medium text-sky-700
                            hover:text-sky-900">
                        Ver todas →
                    </a>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full text-sm text-left">
                        <thead class="bg-slate-50 text-slate-500">
                            <tr>
                                <th class="px-4 py-3 font-medium">Fecha</th>
                                <th class="px-4 py-3 font-medium">Hora</th>
                                <th class="px-4 py-3 font-medium">Mascota</th>
                                <th class="px-4 py-3 font-medium">Estado</th>
                            </tr>
                        </thead>

                        <tbody class="divide-y divide-slate-100">
                            @forelse($proximasCitas as $cita)
                                <tr class="hover:bg-slate-50">
                                    <td class="px-4 py-3 whitespace-nowrap text-slate-700">
                                        {{ \Carbon\Carbon::parse($cita->fecha)->format('d/m/Y') }}
                                    </td>

                                    <td class="px-4 py-3 whitespace-nowrap text-slate-700">
                                        {{ \Carbon\Carbon::parse($cita->hora)->format('h:i A') }}
                                    </td>

                                    <td class="px-4 py-3 font-medium text-slate-800">
                                        {{ $cita->Mascota->nombre ?? 'Sin mascota' }}
                                    </td>

                                    <td class="px-4 py-3">
                                        @php
                                            $estiloEstado = match($cita->estado) {
                                                'Confirmada' => 'bg-emerald-100 text-emerald-700',
                                                'Pendiente' => 'bg-amber-100 text-amber-700',
                                                'En atención' => 'bg-sky-100 text-sky-700',
                                                'Atendida', 'Completa' => 'bg-violet-100 text-violet-700',
                                                'Cancelada' => 'bg-red-100 text-red-700',
                                                'No asistió' => 'bg-slate-200 text-slate-700',
                                                default => 'bg-slate-100 text-slate-600',
                                            };
                                        @endphp

                                        <span class="inline-flex whitespace-nowrap rounded-full
                                                    px-2.5 py-1 text-xs font-medium {{ $estiloEstado }}">
                                            {{ $cita->estado }}
                                        </span>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4"
                                        class="px-4 py-8 text-center text-slate-500">
                                        No hay próximas citas programadas.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </section>
        </div>

        {{-- Gráfica y servicios más solicitados --}}
        <div class="grid grid-cols-1 xl:grid-cols-3 gap-6 mt-6">

            {{-- Gráfico de citas por mes --}}
            <div class="xl:col-span-2 bg-white rounded-xl border border-slate-200 shadow-sm">

                <div class="px-6 py-4 border-b border-slate-200">
                    <h2 class="text-lg font-semibold text-slate-800">
                        Rendimiento de citas
                    </h2>

                    <p class="text-sm text-slate-500 mt-1">
                        Cantidad de citas registradas por mes
                    </p>
                </div>

                <div class="p-6">
                    <div class="h-80">
                        <canvas id="graficaCitas"></canvas>
                    </div>
                </div>

            </div>

            
            {{-- Servicios más solicitados --}}
            <div class="bg-white rounded-xl border border-slate-200 shadow-sm overflow-hidden">

                {{-- Encabezado --}}
                <div class="px-6 py-4 border-b border-slate-200">

                    <h2 class="text-lg font-semibold text-slate-800">
                        Servicios más solicitados
                    </h2>

                    <p class="text-sm text-slate-500 mt-1">
                        Distribución de las citas por servicio
                    </p>

                </div>

                <div class="p-6">

                    {{-- Colores para diferenciar los servicios --}}
                    @php
                        $coloresServicios = [
                            [
                                'barra' => 'bg-[#438195]',
                                'punto' => 'bg-[#438195]',
                                'fondo' => 'bg-[#EAF4F5]',
                                'texto' => 'text-[#306174]',
                            ],
                            [
                                'barra' => 'bg-emerald-500',
                                'punto' => 'bg-emerald-500',
                                'fondo' => 'bg-emerald-50',
                                'texto' => 'text-emerald-700',
                            ],
                            [
                                'barra' => 'bg-amber-500',
                                'punto' => 'bg-amber-500',
                                'fondo' => 'bg-amber-50',
                                'texto' => 'text-amber-700',
                            ],
                            [
                                'barra' => 'bg-violet-500',
                                'punto' => 'bg-violet-500',
                                'fondo' => 'bg-violet-50',
                                'texto' => 'text-violet-700',
                            ],
                            [
                                'barra' => 'bg-rose-500',
                                'punto' => 'bg-rose-500',
                                'fondo' => 'bg-rose-50',
                                'texto' => 'text-rose-700',
                            ],
                        ];
                    @endphp

                    {{-- Lista de servicios --}}
                    @forelse($serviciosMasSolicitados as $servicio)

                        @php
                            $colorServicio = $coloresServicios[
                                $loop->index % count($coloresServicios)
                            ];
                        @endphp

                        <div class="mb-6 last:mb-0">

                            {{-- Nombre y porcentaje --}}
                            <div class="flex items-center justify-between gap-3 mb-3">

                                <div class="flex items-center gap-2 min-w-0">

                                    {{-- Indicador de color --}}
                                    <span class="w-2.5 h-2.5 shrink-0 rounded-full
                                        {{ $colorServicio['punto'] }}">
                                    </span>

                                    {{-- Nombre del servicio --}}
                                    <span class="inline-flex items-center rounded-lg
                                        px-2.5 py-1 text-sm font-medium
                                        {{ $colorServicio['fondo'] }}
                                        {{ $colorServicio['texto'] }}">
                                        {{ $servicio->nombre }}
                                    </span>

                                </div>

                                {{-- Porcentaje --}}
                                <span class="text-sm font-semibold text-slate-800 whitespace-nowrap">
                                    {{ number_format($servicio->porcentaje, 1, ',', '.') }}%
                                </span>

                            </div>

                            {{-- Barra de progreso --}}
                            <div class="h-2.5 w-full overflow-hidden rounded-full bg-slate-100">

                                <div
                                    class="h-full rounded-full transition-all duration-500
                                        {{ $colorServicio['barra'] }}"
                                    style="width: {{ min(100, max(0, $servicio->porcentaje)) }}%">
                                </div>

                            </div>

                            {{-- Cantidad de citas --}}
                            <p class="mt-2 text-xs text-slate-500">
                                {{ $servicio->total }}
                                {{ (int) $servicio->total === 1
                                    ? 'cita registrada'
                                    : 'citas registradas' }}
                            </p>

                        </div>

                    @empty

                        {{-- Cuando todavía no existen servicios solicitados --}}
                        <div class="py-10 text-center">

                            <div class="mx-auto w-12 h-12 rounded-full
                                bg-primary-50 text-primary-600
                                flex items-center justify-center mb-3">

                                @include('layouts.partials.icons', ['icon' => 'servicio'])

                            </div>

                            <p class="text-sm font-medium text-slate-600">
                                No hay servicios solicitados todavía.
                            </p>

                            <p class="mt-1 text-xs text-slate-400">
                                Los datos aparecerán cuando existan citas registradas.
                            </p>

                        </div>

                    @endforelse

                </div>

            </div>


        </div>
    </div>
@endsection

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Citas por mes
            const datosCitas = @json($datosCitasPorMes);

            const meses = datosCitas.map(dato => dato.mes);
            const totales = datosCitas.map(dato => dato.total);

            const elementoCitas = document.getElementById('graficaCitas');

            if (elementoCitas) {
                new Chart(elementoCitas, {
                    type: 'bar',
                    data: {
                        labels: meses,
                        datasets: [{
                            label: 'Citas',
                            data: totales,
                            backgroundColor: '#78AFC0',
                            hoverBackgroundColor: '#438195',
                            borderRadius: 6,
                            maxBarThickness: 28
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            legend: { display: false }
                        },
                        scales: {
                            y: {
                                beginAtZero: true,
                                ticks: { precision: 0 }
                            },
                            x: {
                                grid: { display: false }
                            }
                        }
                    }
                });
            }

            // Servicios más solicitados
            const datosServicios = @json($serviciosMasSolicitados);

            const nombresServicios = datosServicios.map(servicio => servicio.nombre);
            const cantidadesServicios = datosServicios.map(servicio => servicio.total);

            const elementoServicios = document.getElementById('graficaServicios');

            if (elementoServicios && nombresServicios.length > 0) {
                new Chart(elementoServicios, {
                    type: 'bar',
                    data: {
                        labels: nombresServicios,
                        datasets: [{
                            label: 'Citas',
                            data: cantidadesServicios,
                            backgroundColor: '#8BC5B5',
                            hoverBackgroundColor: '#438E7A',
                            borderRadius: 5,
                            maxBarThickness: 24
                        }]
                    },
                    options: {
                        indexAxis: 'y',
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            legend: { display: false }
                        },
                        scales: {
                            x: {
                                beginAtZero: true,
                                ticks: { precision: 0 }
                            },
                            y: {
                                grid: { display: false }
                            }
                        }
                    }
                });
            }
        });
    </script>
@endpush
