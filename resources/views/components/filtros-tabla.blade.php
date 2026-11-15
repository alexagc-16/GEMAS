@props([
    'buscadorId' => 'buscarRegistro',
    'placeholder' => 'Buscar...',
    'filtros' => [],
    'contadorId' => 'contadorRegistros',
    'limpiarId' => 'limpiarFiltros',
    'contadorTotal' => null,
    'contadorTexto' => 'registros encontrados',
])

<form method="GET" action="{{ url()->current() }}" class="space-y-4">

    {{-- Buscador y botón de filtros --}}
    <div class="flex flex-col gap-3 sm:flex-row sm:items-center">

        <div class="relative flex-1">

            <svg class="absolute left-3.5 top-1/2 h-5 w-5
                        -translate-y-1/2 text-slate-400"
                fill="none" stroke="currentColor" viewBox="0 0 24 24">

                <circle cx="11" cy="11" r="7" stroke-width="2"/>
                <path stroke-linecap="round" stroke-linejoin="round"
                    stroke-width="2" d="m16 16 4 4"/>
            </svg>

            <input
                type="text"
                id="{{ $buscadorId }}"
                name="buscar"
                value="{{ request('buscar') }}"
                placeholder="{{ $placeholder }}"
                class="w-full rounded-xl border border-slate-200
                       bg-white py-3 pl-11 pr-4 text-sm text-slate-700
                       placeholder:text-slate-400 shadow-sm
                       transition focus:border-[#40899A]
                       focus:outline-none focus:ring-2
                       focus:ring-[#40899A]/15">
        </div>

        <button type="button"
            data-filtros-boton
            aria-expanded="false"
            class="inline-flex items-center justify-center gap-2
                   rounded-xl border border-slate-200 bg-white
                   px-5 py-3 text-sm font-semibold text-slate-600
                   shadow-sm transition hover:border-[#40899A]/40
                   hover:bg-[#EAF4F5] hover:text-[#40899A]">

            <svg class="h-5 w-5" fill="none" stroke="currentColor"
                viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round"
                    stroke-width="1.8"
                    d="M4 6h16M7 12h10m-7 6h4"/>
            </svg>

            Filtros

            <svg data-filtros-icono
                class="h-4 w-4 transition-transform duration-200"
                fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round"
                    stroke-width="2" d="m6 9 6 6 6-6"/>
            </svg>
        </button>

    </div>

    {{-- Panel de filtros --}}
    <div data-filtros-panel
        class="hidden overflow-hidden rounded-xl border
               border-slate-200 bg-white shadow-sm">

        <div class="flex items-center gap-2 border-b
                    border-slate-100 bg-slate-50/70 px-5 py-3">

            <svg class="h-4 w-4 text-[#40899A]" fill="none"
                stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round"
                    stroke-width="1.8"
                    d="M4 6h16M7 12h10m-7 6h4"/>
            </svg>

            <h3 class="text-sm font-semibold text-slate-700">
                Filtrar registros
            </h3>

        </div>

        <div class="flex flex-wrap justify-center gap-5 p-5">

            @foreach ($filtros as $filtro)

                <div class="w-full max-w-md sm:w-[calc(50%-0.625rem)]">

                    <label for="{{ $filtro['id'] }}"
                        class="mb-2 block text-sm font-medium normal-case tracking-wide text-slate-500">
                        {{ $filtro['label'] }}
                    </label>

                    @if (($filtro['tipo'] ?? 'select') === 'date')

                        <input
                        type="date"
                        id="{{ $filtro['id'] }}"
                        name="{{ $filtro['name'] ?? $filtro['id'] }}"
                        value="{{ request($filtro['name'] ?? $filtro['id']) }}"
                        class="w-full rounded-lg border border-slate-200
                            bg-slate-50 px-3 py-2.5 text-sm text-slate-700
                            transition focus:border-[#40899A]
                            focus:bg-white focus:outline-none
                            focus:ring-2 focus:ring-[#40899A]/15">

                    @else

                        <select
                            id="{{ $filtro['id'] }}"
                            name="{{ $filtro['name'] ?? $filtro['id'] }}"
                            class="w-full rounded-lg border border-slate-200
                                bg-slate-50 px-3 py-2.5 text-sm text-slate-700
                                transition focus:border-[#40899A]
                                focus:bg-white focus:outline-none
                                focus:ring-2 focus:ring-[#40899A]/15">

                            <option value="">
                                {{ $filtro['todos'] ?? 'Todos' }}
                            </option>

                            @foreach ($filtro['opciones'] ?? [] as $valor => $texto)
                                <option value="{{ $valor }}"
                                    @selected(request($filtro['name'] ?? $filtro['id']) == $valor)>
                                    {{ $texto }}
                                </option>
                            @endforeach

                        </select>

                    @endif

                </div>

            @endforeach

        </div>

        {{-- Acciones de filtros --}}
        <div class="flex flex-col-reverse gap-2 border-t
                    border-slate-100 bg-slate-50/70 px-5 py-4
                    sm:flex-row sm:justify-end">
            {{--
            <button type="button"
                data-filtros-limpiar
                class="inline-flex items-center justify-center gap-2
                       rounded-lg border border-slate-200 bg-white
                       px-4 py-2.5 text-sm font-semibold text-slate-600
                       transition hover:bg-slate-100">

                <svg class="h-4 w-4" fill="none" stroke="currentColor"
                    viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        stroke-width="1.8"
                        d="M4 7h16M10 11v6m4-6v6M5 7l1 14h12l1-14M9 7V4h6v3"/>
                </svg>

                Restablecer
            </button>--}}

            <button type="submit"
                data-filtros-buscar
                class="inline-flex items-center justify-center gap-2
                       rounded-lg bg-[#40899A] px-5 py-2.5
                       text-sm font-semibold text-white
                       shadow-sm transition hover:bg-[#347787]">

                <svg class="h-4 w-4" fill="none" stroke="currentColor"
                    viewBox="0 0 24 24">
                    <circle cx="11" cy="11" r="7" stroke-width="2"/>
                    <path stroke-linecap="round" stroke-linejoin="round"
                        stroke-width="2" d="m16 16 4 4"/>
                </svg>

                Aplicar filtros
            </button>

        </div>

    </div>

    {{-- Contador y limpieza general --}}
    <div class="flex flex-col gap-3 px-1 sm:flex-row sm:items-center sm:justify-between">

        <p id="{{ $contadorId }}"
            class="text-sm text-slate-500"
            aria-live="polite">
            {{ $contadorTotal ?? 0 }} {{ $contadorTexto }}
        </p>

        <a href="{{ url()->current() }}"
            id="{{ $limpiarId }}"
            class="inline-flex items-center justify-center gap-1.5
                self-start rounded-lg px-3 py-2
                text-sm font-medium text-[#40899A]
                transition hover:bg-[#EAF4F5]
                hover:text-[#306f7e]
                sm:mr-3 sm:self-auto">

            <svg class="h-4 w-4" fill="none" stroke="currentColor"
                viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round"
                    stroke-width="1.8"
                    d="M4 7h16M10 11v6m4-6v6M5 7l1 14h12l1-14M9 7V4h6v3"/>
            </svg>

            Limpiar filtros
        </a>

    </div>

</form>

<script>
    function inicializarFiltrosTabla() {

        document.querySelectorAll('[data-filtros-boton]').forEach(boton => {

            // Evita registrar dos veces el mismo evento.
            if (boton.dataset.inicializado === 'true') {
                return;
            }

            const contenedor = boton.parentElement.parentElement;
            const panel = contenedor.querySelector('[data-filtros-panel]');
            const icono = boton.querySelector('[data-filtros-icono]');

            if (!panel || !icono) {
                return;
            }

            boton.dataset.inicializado = 'true';

            boton.addEventListener('click', function () {

                const abrir = panel.classList.contains('hidden');

                panel.classList.toggle('hidden', !abrir);

                boton.setAttribute('aria-expanded', String(abrir));

                icono.classList.toggle('rotate-180', abrir);

            });

        });

    }

    // Funciona tanto si el documento ya cargó como si todavía está cargando.
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', inicializarFiltrosTabla);
    } else {
        inicializarFiltrosTabla();
    }
</script>

