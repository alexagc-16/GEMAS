    {{-- Vista calendario --}}
    <div id="vistaCalendario"
        class="hidden overflow-hidden rounded-xl border border-slate-200 bg-white shadow-sm">

        {{-- Encabezado: igual al de la lista --}}
        <div class="border-b border-slate-200 px-6 py-5">
            <h2 class="text-lg font-semibold text-slate-800">
                Citas registradas
            </h2>

            <p class="mt-1 text-sm text-slate-500">
                Información de las mascotas, los veterinarios y los servicios programados.
            </p>
        </div>

        {{-- Selector de vista --}}
        <div class="flex justify-center px-6 py-5">

            <div class="inline-flex items-center gap-1 rounded-full
                        border border-slate-200 bg-slate-100/80 p-1.5">

                <button type="button" id="btnVistaListaCalendario"
                    class="inline-flex items-center justify-center gap-2
                        rounded-full px-5 py-2 text-sm font-medium
                        text-slate-500 transition-all duration-200
                        hover:text-[#40899A]">

                    <svg class="h-4 w-4" fill="none" stroke="currentColor"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            stroke-width="1.8"
                            d="M8 6h13M8 12h13M8 18h13M3 6h.01M3 12h.01M3 18h.01"/>
                    </svg>

                    Lista
                </button>

                <button type="button" id="btnVistaCalendarioCalendario"
                    class="inline-flex items-center justify-center gap-2
                        rounded-full bg-white px-5 py-2
                        text-sm font-semibold text-[#40899A]
                        shadow-sm ring-1 ring-slate-200/70
                        transition-all duration-200">

                    <svg class="h-4 w-4" fill="none" stroke="currentColor"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            stroke-width="1.8"
                            d="M8 2v4m8-4v4M3 10h18M5 4h14a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V6a2 2 0 0 1 2-2Z"/>
                    </svg>

                    Calendario
                </button>

            </div>
        </div>

        {{-- Navegación del calendario --}}
        <div class="px-4 pb-5 sm:px-6">

            <div class="mb-4 flex flex-col gap-3 sm:flex-row
                        sm:items-center sm:justify-between">

                <div class="flex items-center justify-center gap-3 sm:justify-start">

                    <button type="button" id="mesAnterior"
                        class="flex h-9 w-9 items-center justify-center
                            rounded-lg border border-slate-200 bg-white
                            text-slate-600 transition hover:bg-[#EAF4F5]
                            hover:text-[#40899A]">

                        <svg class="h-5 w-5" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                stroke-width="2" d="m15 18-6-6 6-6"/>
                        </svg>
                    </button>

                    <h3 id="tituloMes"
                        class="min-w-44 text-center text-base font-semibold capitalize text-slate-800 sm:text-lg">
                        —
                    </h3>

                    <button type="button" id="mesSiguiente"
                        class="flex h-9 w-9 items-center justify-center
                            rounded-lg border border-slate-200 bg-white
                            text-slate-600 transition hover:bg-[#EAF4F5]
                            hover:text-[#40899A]">

                        <svg class="h-5 w-5" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                stroke-width="2" d="m9 18 6-6-6-6"/>
                        </svg>
                    </button>

                </div>

                <button type="button" id="mesActual"
                    class="inline-flex items-center justify-center gap-2
                        rounded-lg border border-[#40899A]/30
                        bg-[#EAF4F5] px-4 py-2
                        text-sm font-semibold text-[#40899A]
                        transition hover:bg-[#d5ebed]">

                    <svg class="h-4 w-4" fill="none" stroke="currentColor"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            stroke-width="1.8"
                            d="M8 2v4m8-4v4M3 10h18M5 4h14a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V6a2 2 0 0 1 2-2Z"/>
                    </svg>

                    Hoy
                </button>

            </div>

            {{-- Calendario --}}
            <div class="overflow-hidden rounded-xl border border-slate-200 bg-white">

                <div class="grid grid-cols-7 border-b border-slate-200 bg-slate-50">

                    @foreach (['Lun', 'Mar', 'Mié', 'Jue', 'Vie', 'Sáb', 'Dom'] as $dia)
                        <div class="px-1 py-3 text-center text-xs
                                    font-semibold text-slate-500 sm:text-sm">
                            {{ $dia }}
                        </div>
                    @endforeach

                </div>

                <div id="diasCalendario" class="grid grid-cols-7">
                    {{-- Días generados con JavaScript --}}
                </div>

            </div>

            <p class="mt-4 text-xs text-slate-500">
                Selecciona una cita para consultar su información y las acciones disponibles.
            </p>

        </div>
    </div>
    
    {{-- Modal de información de la cita --}}
    <div id="modalDetalleCalendario"
        class="fixed inset-0 z-[60] hidden items-center justify-center
            bg-slate-900/50 p-4 backdrop-blur-sm">

        <div class="w-full max-w-xl overflow-hidden rounded-2xl
            bg-white shadow-2xl">

            {{-- Encabezado --}}
            <div class="flex items-center justify-between
                border-b border-slate-100 px-6 py-4">

                <div>
                    <h3 class="text-lg font-semibold text-slate-800">
                        Detalles de la cita
                    </h3>

                    <p class="mt-1 text-sm text-slate-500">
                        Información de la atención veterinaria
                    </p>
                </div>

                <button type="button" id="cerrarDetalleCalendario"
                    class="flex h-9 w-9 items-center justify-center
                        rounded-lg text-slate-400 transition
                        hover:bg-slate-100 hover:text-slate-700"
                    aria-label="Cerrar modal">

                    <svg class="h-5 w-5" fill="none"
                        stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round"
                            stroke-linejoin="round" stroke-width="2"
                            d="M6 18 18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>

            {{-- Contenido --}}
            <div class="space-y-5 px-6 py-5">

                {{-- Presentación de la mascota --}}
                <div class="flex items-center gap-4 rounded-xl
                    border border-[#40899A]/15 bg-[#EAF4F5]/60 p-4">

                    {{-- Fotografía --}}
                    <div class="flex h-20 w-20 shrink-0 items-center
                        justify-center overflow-hidden rounded-full
                        border border-white bg-white shadow-sm">

                        <img id="detalleImagen"
                            src=""
                            alt="Fotografía de la mascota"
                            class="hidden h-full w-full object-cover">

                        {{-- Icono cuando no hay fotografía --}}
                        <span id="detalleImagenFallback"
                            class="flex h-full w-full items-center
                                justify-center text-[#40899A]">

                            <span class="flex h-10 w-10 items-center justify-center">
                                @include('layouts.partials.icons', ['icon' => 'mascota'])
                            </span>
                        </span>

                    </div>

                    {{-- Nombre y estado --}}
                    <div class="min-w-0 flex-1">

                        <p class="text-xs font-medium uppercase
                            tracking-wide text-slate-500">
                            Mascota
                        </p>

                        <h4 id="detalleMascota"
                            class="mt-1 break-words text-lg
                                font-bold text-slate-800">
                            —
                        </h4>

                        <span id="detalleEstado"
                            class="mt-2 inline-flex rounded-full
                                bg-blue-50 px-3 py-1 text-xs
                                font-semibold text-blue-700">
                            —
                        </span>

                    </div>
                </div>

                {{-- Información de la cita --}}
                <div>
                    <h4 class="mb-3 text-sm font-semibold text-slate-800">
                        Información de la cita
                    </h4>

                    <div class="grid grid-cols-2 gap-3">

                        {{-- Fecha --}}
                        <div class="rounded-lg border border-slate-100
                            bg-slate-50/70 p-3">

                            <div class="flex items-center gap-2
                                text-slate-400">

                                <svg class="h-4 w-4" fill="none"
                                    stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round"
                                        stroke-linejoin="round" stroke-width="1.8"
                                        d="M8 2v4m8-4v4M3 10h18M5 4h14a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V6a2 2 0 0 1 2-2Z"/>
                                </svg>

                                <span class="text-xs font-medium">
                                    Fecha
                                </span>
                            </div>

                            <p id="detalleFecha"
                                class="mt-2 text-sm font-semibold text-slate-700">
                                —
                            </p>
                        </div>

                        {{-- Hora --}}
                        <div class="rounded-lg border border-slate-100
                            bg-slate-50/70 p-3">

                            <div class="flex items-center gap-2
                                text-slate-400">

                                <svg class="h-4 w-4" fill="none"
                                    stroke="currentColor" viewBox="0 0 24 24">
                                    <circle cx="12" cy="12" r="9"
                                        stroke-width="1.8"/>
                                    <path stroke-linecap="round"
                                        stroke-linejoin="round" stroke-width="1.8"
                                        d="M12 7v5l3 2"/>
                                </svg>

                                <span class="text-xs font-medium">
                                    Hora
                                </span>
                            </div>

                            <p id="detalleHora"
                                class="mt-2 text-sm font-semibold text-slate-700">
                                —
                            </p>
                        </div>

                        {{-- Veterinario --}}
                        <div class="rounded-lg border border-slate-100
                            bg-slate-50/70 p-3">

                            <p class="text-xs font-medium text-slate-500">
                                Veterinario
                            </p>

                            <p id="detalleVeterinario"
                                class="mt-2 break-words text-sm
                                    font-semibold text-slate-700">
                                —
                            </p>
                        </div>

                        {{-- Servicio --}}
                        <div class="rounded-lg border border-slate-100
                            bg-slate-50/70 p-3">

                            <p class="text-xs font-medium text-slate-500">
                                Servicio
                            </p>

                            <p id="detalleServicio"
                                class="mt-2 break-words text-sm
                                    font-semibold text-slate-700">
                                —
                            </p>
                        </div>

                    </div>
                </div>

                {{-- Motivo --}}
                <div class="rounded-lg border border-slate-100 p-4">

                    <p class="text-xs font-semibold text-slate-500">
                        Motivo de la consulta
                    </p>

                    <p id="detalleMotivo"
                        class="mt-2 whitespace-pre-line break-words
                            text-sm leading-relaxed text-slate-700">
                        —
                    </p>
                </div>

            </div>

            {{-- Acciones --}}
            <div id="accionesDetalleCalendario"
                class="flex flex-wrap justify-end gap-2
                    border-t border-slate-100 bg-slate-50/70 px-6 py-4">

                {{-- Cancelar --}}
                <button type="button" id="cancelarDetalleCalendario"
                    class="hidden inline-flex items-center justify-center
                        gap-1.5 rounded-lg bg-amber-50 px-3 py-2
                        text-xs font-semibold text-amber-700
                        transition hover:bg-amber-100">

                    <svg class="h-4 w-4" fill="none"
                        stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round"
                            stroke-linejoin="round" stroke-width="2"
                            d="M6 18 18 6M6 6l12 12"/>
                    </svg>

                    Cancelar
                </button>

                {{-- Atender / Continuar consulta --}}
                <a id="atenderDetalleCalendario" href="#"
                    class="hidden inline-flex items-center justify-center
                        gap-1.5 rounded-lg bg-[#EAF4F5] px-3 py-2
                        text-xs font-semibold text-[#40899A]
                        transition hover:bg-[#d5ebed]">

                    @include('layouts.partials.icons', ['icon' => 'historiaclinica'])

                    <span id="textoAtenderCalendario">Atender</span>
                </a>

                {{-- No asistió --}}
                <button type="button" id="inasistenciaDetalleCalendario"
                    class="hidden inline-flex items-center justify-center
                        gap-1.5 rounded-lg bg-slate-100 px-3 py-2
                        text-xs font-semibold text-slate-700
                        transition hover:bg-slate-200">

                    <svg class="h-4 w-4" fill="none"
                        stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round"
                            stroke-linejoin="round" stroke-width="2"
                            d="M12 9v4m0 4h.01M10.3 3.9 2.6 17.2A2 2 0 0 0 4.3 20h15.4a2 2 0 0 0 1.7-2.8L13.7 3.9a2 2 0 0 0-3.4 0Z"/>
                    </svg>

                    No asistió
                </button>

                {{-- Cerrar --}}
                <button type="button" id="cerrarDetalleCalendarioPie"
                    class="inline-flex items-center justify-center
                        rounded-lg border border-slate-200 bg-white
                        px-4 py-2 text-xs font-semibold text-slate-600
                        transition hover:bg-slate-100">

                    Cerrar
                </button>

            </div>

        </div>
    </div>

    {{-- Modal de confirmación de inasistencia del calendario --}}
    <div id="modalInasistenciaCalendario"
        class="fixed inset-0 z-[70] hidden items-center justify-center bg-slate-900/50 p-4">

        <div class="w-full max-w-md rounded-xl bg-white shadow-xl">
            <div class="border-b border-slate-100 px-6 py-4">
                <h3 class="text-lg font-semibold text-slate-800">Confirmar inasistencia</h3>
            </div>

            <div class="px-6 py-5">
                <p class="text-sm text-slate-600">
                    ¿Estás seguro de que deseas marcar esta cita como
                    <strong>No asistió</strong>?
                </p>
            </div>

            <div class="flex justify-end gap-3 border-t border-slate-100 px-6 py-4">
                <button type="button" id="cerrarInasistenciaCalendario"
                    class="rounded-lg border border-slate-300 px-4 py-2 text-sm font-semibold text-slate-600 hover:bg-slate-50">
                    Volver
                </button>

                <form id="formInasistenciaCalendario" method="POST">
                    @csrf
                    <button type="submit"
                        class="rounded-lg bg-amber-500 px-4 py-2 text-sm font-semibold text-white hover:bg-amber-600">
                        Confirmar
                    </button>
                </form>
            </div>
        </div>
    </div>

    {{-- Datos y funcionamiento del calendario --}}
    <script>
        document.addEventListener('DOMContentLoaded', function () {

            const citas = {{ Illuminate\Support\Js::from(
                $citasCalendario->map(function ($cita) {
                    $usuario = auth()->user();

                    $esVeterinarioAsignado = $usuario
                        && $usuario->hasRole('veterinario')
                        && $usuario->documentoIdentidad === ($cita->Veterinario->documentoIdentidad ?? null);

                    return [
                        'id' => $cita->id,
                        'fecha' => \Carbon\Carbon::parse($cita->fecha)->format('Y-m-d'),
                        'hora' => \Carbon\Carbon::parse($cita->hora)->format('H:i'),
                        'horaMostrar' => \Carbon\Carbon::parse($cita->hora)->format('h:i A'),
                        'mascota' => $cita->Mascota->nombre ?? 'Sin mascota',
                        'especie' => $cita->Mascota->especie ?? '',
                        'imagen' => $cita->Mascota?->imagen &&
                            file_exists(public_path('storage/' . $cita->Mascota->imagen))
                                ? asset('storage/' . $cita->Mascota->imagen)
                                : null,
                        'veterinario' => $cita->Veterinario->nombre ?? 'Sin asignar',
                        'servicio' => $cita->Servicio->nombre ?? 'Sin servicio',
                        'motivo' => $cita->motivo ?: 'Sin motivo registrado',
                        'estado' => $cita->estado,
                        'esVeterinarioAsignado' => $esVeterinarioAsignado,
                        'showUrl' => route('cita.show', $cita->id),
                        'noAsistioUrl' => route('cita.noAsistio', $cita->id),
                        'fechaCancelacion' => $cita->CancelacionCita?->fechaCancelacion?->format('d/m/Y H:i') ?? 'Sin fecha',

                        'tipoCancelador' => $cita->CancelacionCita?->tipoCancelador ?? 'No registrado',

                        'motivoCancelacion' => $cita->CancelacionCita?->motivo ?? 'No se registró un motivo de cancelación',
                    ];
                })
            ) }};

            const iconoMascota = {{ Illuminate\Support\Js::from(
                view('layouts.partials.icons', ['icon' => 'mascota'])->render()
            ) }};
            const contenedorDias = document.getElementById('diasCalendario');
            const tituloMes = document.getElementById('tituloMes');
            const modalDetalle = document.getElementById('modalDetalleCalendario');
            const modalInasistencia = document.getElementById('modalInasistenciaCalendario');

            let fechaActual = new Date();
            let mesVisible = new Date(fechaActual.getFullYear(), fechaActual.getMonth(), 1);

            const nombresMeses = [
                'enero', 'febrero', 'marzo', 'abril', 'mayo', 'junio',
                'julio', 'agosto', 'septiembre', 'octubre', 'noviembre', 'diciembre'
            ];

            function fechaLocal(fecha) {
                const año = fecha.getFullYear();
                const mes = String(fecha.getMonth() + 1).padStart(2, '0');
                const dia = String(fecha.getDate()).padStart(2, '0');

                return `${año}-${mes}-${dia}`;
            }

            function escaparHTML(valor) {
                return String(valor ?? '').replace(/[&<>"']/g, caracter => ({
                    '&': '&amp;',
                    '<': '&lt;',
                    '>': '&gt;',
                    '"': '&quot;',
                    "'": '&#39;'
                })[caracter]);
            }

            function renderizarCalendario() {
                const año = mesVisible.getFullYear();
                const mes = mesVisible.getMonth();

                tituloMes.textContent =
                    `${nombresMeses[mes].charAt(0).toUpperCase() + nombresMeses[mes].slice(1)} ${año}`;

                const primerDia = new Date(año, mes, 1);
                const ultimoDia = new Date(año, mes + 1, 0);

                // Ajustar para que la semana comience el lunes.
                const espaciosIniciales = (primerDia.getDay() + 6) % 7;
                const totalDias = ultimoDia.getDate();

                const totalCeldas = Math.ceil((espaciosIniciales + totalDias) / 7) * 7;

                contenedorDias.innerHTML = '';

                for (let indice = 0; indice < totalCeldas; indice++) {
                    const numeroDia = indice - espaciosIniciales + 1;
                    const perteneceMes = numeroDia >= 1 && numeroDia <= totalDias;

                    const celda = document.createElement('div');

                    celda.className =
                        'min-h-28 border-b border-r border-slate-100 p-1.5 sm:min-h-36 sm:p-2';

                    if (!perteneceMes) {
                        celda.classList.add('bg-slate-50/70');
                        contenedorDias.appendChild(celda);
                        continue;
                    }

                    const fechaCelda = new Date(año, mes, numeroDia);
                    const fechaTexto = fechaLocal(fechaCelda);
                    const esHoy = fechaTexto === fechaLocal(fechaActual);

                    const encabezado = document.createElement('div');
                    encabezado.className = 'mb-2 flex justify-end';

                    encabezado.innerHTML = `
                        <span class="${esHoy
                            ? 'flex h-7 w-7 items-center justify-center rounded-full bg-[#40899A] text-xs font-bold text-white'
                            : 'flex h-7 w-7 items-center justify-center text-xs font-medium text-slate-600'}">
                            ${numeroDia}
                        </span>
                    `;

                    celda.appendChild(encabezado);

                    const citasDelDia = citas.filter(cita => cita.fecha === fechaTexto);

                    // Ordenar las citas por hora (de menor a mayor).
                    citas.sort((a, b) => a.hora.localeCompare(b.hora));

                    citasDelDia.forEach(cita => {
                        const boton = document.createElement('button');
                        boton.type = 'button';

                        let colorEstado = 'bg-slate-100 text-slate-700';

                        if (cita.estado === 'Confirmada') {
                            colorEstado = 'bg-blue-50 text-blue-700';
                        } else if (cita.estado === 'En atención') {
                            colorEstado = 'bg-amber-50 text-amber-700';
                        } else if (cita.estado === 'Atendida') {
                            colorEstado = 'bg-green-50 text-green-700';
                        } else if (cita.estado === 'Cancelada') {
                            colorEstado = 'bg-red-50 text-red-700';
                        }

                        boton.className =
                            `mb-1 block w-full rounded-md px-1.5 py-1.5 text-left text-[10px] leading-4 transition hover:ring-1 hover:ring-[#40899A] sm:text-xs ${colorEstado}`;

                        boton.innerHTML = `
                            <span class="shrink-0 font-medium text-[10px]">
                                ${escaparHTML(cita.horaMostrar)} - 
                            </span>

                            <span class="min-w-0 flex-1 truncate font-semibold text-[10px]">
                                ${escaparHTML(cita.mascota)}
                            </span>

                            <span class="min-w-0 flex-1 truncate font-semibold text-[10px]">
                                · ${escaparHTML(cita.especie)}
                            </span>
                        `;

                        boton.title = `${cita.mascota} - ${cita.especie} · ${cita.horaMostrar}`;

                        boton.addEventListener('click', () => abrirDetalle(cita));

                        celda.appendChild(boton);
                    });

                    contenedorDias.appendChild(celda);
                }
            }

            
            function abrirDetalle(cita) {

                // Información de la mascota.
                document.getElementById('detalleMascota').textContent = cita.mascota;

                // Fotografía o icono de respaldo.
                const imagenDetalle = document.getElementById('detalleImagen');
                const imagenFallback = document.getElementById('detalleImagenFallback');

                imagenDetalle.classList.add('hidden');
                imagenFallback.classList.remove('hidden');

                imagenDetalle.onerror = function () {
                    imagenDetalle.classList.add('hidden');
                    imagenFallback.classList.remove('hidden');
                };

                if (cita.imagen) {
                    imagenDetalle.src = cita.imagen;
                    imagenDetalle.alt = `Fotografía de ${cita.mascota}`;
                    imagenDetalle.classList.remove('hidden');
                    imagenFallback.classList.add('hidden');
                } else {
                    imagenDetalle.removeAttribute('src');
                }

                // Estado de la cita.
                const detalleEstado = document.getElementById('detalleEstado');

                detalleEstado.textContent = cita.estado;

                const coloresEstado = {
                    'Confirmada': 'bg-blue-50 text-blue-700',
                    'En atención': 'bg-amber-50 text-amber-700',
                    'Atendida': 'bg-green-50 text-green-700',
                    'Cancelada': 'bg-red-50 text-red-700',
                    'No asistió': 'bg-slate-100 text-slate-700',
                    'Pendiente': 'bg-slate-100 text-slate-700'
                };

                detalleEstado.className =
                    'mt-2 inline-flex rounded-full px-3 py-1 text-xs font-semibold ' +
                    (coloresEstado[cita.estado] || 'bg-slate-100 text-slate-700');

                // Resto de la información.
                document.getElementById('detalleFecha').textContent =
                    cita.fecha.split('-').reverse().join('/');

                document.getElementById('detalleHora').textContent = cita.horaMostrar;
                document.getElementById('detalleVeterinario').textContent = cita.veterinario;
                document.getElementById('detalleServicio').textContent = cita.servicio;
                document.getElementById('detalleMotivo').textContent = cita.motivo;

                const botonCancelar = document.getElementById('cancelarDetalleCalendario');
                const botonAtender = document.getElementById('atenderDetalleCalendario');
                const botonInasistencia = document.getElementById('inasistenciaDetalleCalendario');

                const textoAtender = document.getElementById('textoAtenderCalendario');

                // Ocultar todas las acciones inicialmente.
                botonCancelar.classList.add('hidden');
                botonAtender.classList.add('hidden');
                botonInasistencia.classList.add('hidden');

                // Citas confirmadas o en atención.
                if (['Confirmada', 'En atención'].includes(cita.estado)) {

                    botonCancelar.classList.remove('hidden');

                    if (cita.esVeterinarioAsignado) {

                        botonAtender.classList.remove('hidden');
                        botonAtender.href = cita.showUrl;

                        textoAtender.textContent =
                            cita.estado === 'En atención'
                                ? 'Continuar consulta'
                                : 'Atender';

                        if (cita.estado === 'Confirmada') {
                            botonInasistencia.classList.remove('hidden');
                        }
                    }
                }

                // Cancelación.
                botonCancelar.onclick = function () {

                    cerrarDetalle();

                    if (typeof abrirModalCancelar === 'function') {
                        abrirModalCancelar(
                            cita.id,
                            cita.mascota,
                            cita.fecha,
                            cita.hora,
                            cita.motivo
                        );
                    }
                };

                // Inasistencia.
                botonInasistencia.onclick = function () {

                    document.getElementById('formInasistenciaCalendario').action =
                        cita.noAsistioUrl;

                    modalInasistencia.classList.remove('hidden');
                    modalInasistencia.classList.add('flex');
                };

                // Mostrar modal.
                modalDetalle.classList.remove('hidden');
                modalDetalle.classList.add('flex');
            }


            function cerrarDetalle() {
                modalDetalle.classList.add('hidden');
                modalDetalle.classList.remove('flex');
            }

            function abrirModalCancelarDesdeCalendario(cita) {
                // Reutilizar el modal de cancelación que ya existe en Cita.index.
                if (typeof abrirModalCancelar === 'function') {
                    abrirModalCancelar(cita.id, cita.mascota);
                }
            }

            function cerrarModalInasistencia() {
                modalInasistencia.classList.add('hidden');
                modalInasistencia.classList.remove('flex');
            }

            document.getElementById('mesAnterior').addEventListener('click', function () {
                mesVisible.setMonth(mesVisible.getMonth() - 1);
                renderizarCalendario();
            });

            document.getElementById('mesSiguiente').addEventListener('click', function () {
                mesVisible.setMonth(mesVisible.getMonth() + 1);
                renderizarCalendario();
            });

            document.getElementById('mesActual').addEventListener('click', function () {
                mesVisible = new Date(fechaActual.getFullYear(), fechaActual.getMonth(), 1);
                renderizarCalendario();
            });

            document.getElementById('cerrarDetalleCalendario').addEventListener('click', cerrarDetalle);
            document.getElementById('cerrarDetalleCalendarioPie').addEventListener('click', cerrarDetalle);

            document.getElementById('cerrarInasistenciaCalendario').addEventListener('click', cerrarModalInasistencia);

            modalDetalle.addEventListener('click', function (event) {
                if (event.target === modalDetalle) cerrarDetalle();
            });

            modalInasistencia.addEventListener('click', function (event) {
                if (event.target === modalInasistencia) cerrarModalInasistencia();
            });

                
            // Cambiar entre la vista de lista y el calendario.
            const vistaLista = document.getElementById('vistaLista');
            const vistaCalendario = document.getElementById('vistaCalendario');

            const botonesLista = [
                document.getElementById('btnVistaLista'),
                document.getElementById('btnVistaListaCalendario')
            ];

            const botonesCalendario = [
                document.getElementById('btnVistaCalendario'),
                document.getElementById('btnVistaCalendarioCalendario')
            ];

            const claseActiva =
                'inline-flex items-center justify-center gap-2 rounded-full bg-white px-5 py-2 text-sm font-semibold text-[#40899A] shadow-sm ring-1 ring-slate-200/70 transition-all duration-200';

            const claseInactiva =
                'inline-flex items-center justify-center gap-2 rounded-full px-5 py-2 text-sm font-medium text-slate-500 transition-all duration-200 hover:text-[#40899A]';

            function cambiarVista(vista) {

                const mostrarLista = vista === 'lista';

                vistaLista.classList.toggle('hidden', !mostrarLista);
                vistaCalendario.classList.toggle('hidden', mostrarLista);

                botonesLista.forEach(boton => {
                    boton.className = mostrarLista ? claseActiva : claseInactiva;
                });

                botonesCalendario.forEach(boton => {
                    boton.className = mostrarLista ? claseInactiva : claseActiva;
                });

                // Actualizar el calendario al mostrarlo.
                if (!mostrarLista) {
                    renderizarCalendario();
                }
            }

            botonesLista.forEach(boton => {
                boton.addEventListener('click', () => cambiarVista('lista'));
            });

            botonesCalendario.forEach(boton => {
                boton.addEventListener('click', () => cambiarVista('calendario'));
            });

        });
        
    </script>