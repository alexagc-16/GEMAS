<!DOCTYPE html>
<html lang="es" class="h-full bg-slate-50">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>@yield('title', 'Seguridad') - {{ config('app.name', 'GEMAS') }}</title>

    {{-- Tailwind CSS --}}
    <script src="https://cdn.tailwindcss.com"></script>

    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: {
                            50: '#EEF6F8',
                            100: '#DCEEF2',
                            200: '#C0E0E6',
                            300: '#A0CED7',
                            400: '#7FB9C5',
                            500: '#4A90A4',
                            600: '#438195',
                            700: '#397184',
                            800: '#306174',
                            900: '#285364'
                        }
                    },
                    fontFamily: {
                        sans: ['Inter', 'ui-sans-serif', 'system-ui', 'sans-serif']
                    }
                }
            }
        }
    </script>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap"
        rel="stylesheet">

    <style>
        [x-cloak] {
            display: none !important;
        }

        body {
            font-family: 'Inter', ui-sans-serif, system-ui, sans-serif;
        }
    </style>

    @stack('styles')
</head>

<body class="h-full text-slate-800 antialiased">

    {{-- Contenedor principal --}}
    <div
        x-data="{
            sidebarOpen: false,
            sidebarCollapsed: false
        }"
        class="min-h-screen"
    >

        {{-- Fondo para menú móvil --}}
        <div
            x-show="sidebarOpen"
            x-cloak
            @click="sidebarOpen = false"
            class="fixed inset-0 z-30 bg-slate-900/50 lg:hidden"
            aria-hidden="true"
        ></div>

        {{-- Sidebar de seguridad --}}
        <aside
            x-cloak
            :class="[
                sidebarOpen ? 'translate-x-0' : '-translate-x-full lg:translate-x-0',
                sidebarCollapsed ? 'lg:w-20' : 'lg:w-64'
            ]"
            class="fixed inset-y-0 left-0 z-40 w-64
                bg-slate-900 text-slate-300 border-r border-slate-800
                transform transition-all duration-300 ease-in-out
                lg:translate-x-0"
            aria-label="Menú del módulo de seguridad"
        >

            <div class="h-full flex flex-col">

                {{-- Logo GEMAS --}}
                <div
                    class="flex items-center justify-center h-28
                        border-b border-slate-800 transition-all duration-300"
                    :class="sidebarCollapsed ? 'px-2' : 'px-4'"
                >
                    <button
                        type="button"
                        @click="sidebarCollapsed = !sidebarCollapsed"
                        class="flex items-center justify-center w-full h-full
                            rounded-lg border-0 outline-none
                            hover:bg-transparent
                            focus:outline-none focus:ring-0
                            transition-all duration-300"
                        :title="sidebarCollapsed ? 'Expandir menú' : 'Contraer menú'"
                        aria-label="Contraer o expandir menú"
                    >

                        {{-- Logo expandido --}}
                        <img
                            x-show="!sidebarCollapsed"
                            x-transition
                            src="{{ asset('img/logo.png') }}"
                            alt="GEMAS"
                            class="w-[95px] h-[95px] object-contain"
                        >

                        {{-- Logo contraído --}}
                        <img
                            x-show="sidebarCollapsed"
                            x-transition
                            src="{{ asset('img/logo.png') }}"
                            alt="GEMAS"
                            class="w-12 h-12 object-contain"
                        >

                    </button>
                </div>

                {{-- Navegación de seguridad --}}
                <nav
                    class="flex-1 overflow-y-auto
                        [scrollbar-width:none]
                        [&::-webkit-scrollbar]:hidden
                        py-6 space-y-1 transition-all duration-300"
                    :class="sidebarCollapsed ? 'px-2' : 'px-3'"
                    aria-label="Navegación de seguridad"
                >

                    {{-- Título --}}
                    <div
                        x-show="!sidebarCollapsed"
                        x-transition
                        class="text-xs font-semibold text-slate-400
                            uppercase tracking-wider px-3 mb-3"
                    >
                        Módulo de seguridad
                    </div>

                    {{-- Botones internos --}}
                    @foreach ([
                        [
                            'ruta' => 'seguridad.roles.index',
                            'texto' => 'Roles',
                            'patron' => 'seguridad.roles.*',
                            'icono' => '<path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 002.625.372 9.337 9.337 0 004.121-.952 4.125 4.125 0 00-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 018.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0111.964-3.07M12 6.375a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zm8.25 2.25a2.625 2.625 0 11-5.25 0 2.625 2.625 0 015.25 0z"/>'
                        ],
                        [
                            'ruta' => 'seguridad.permisos.index',
                            'texto' => 'Permisos',
                            'patron' => 'seguridad.permisos.*',
                            'icono' => '<path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75m-3-7.036A11.959 11.959 0 013.598 6 11.99 11.99 0 003 9.749c0 5.592 3.824 10.29 9 11.623 5.176-1.332 9-6.03 9-11.622 0-1.31-.21-2.571-.598-3.751h-.152c-3.196 0-6.1-1.248-8.25-3.285z"/>'
                        ],
                        [
                            'ruta' => 'seguridad.cuentas.index',
                            'texto' => 'Cuentas de usuario',
                            'patron' => 'seguridad.cuentas.*',
                            'icono' => '<path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z"/>'
                        ],
                        [
                            'ruta' => 'seguridad.usuarios.index',
                            'texto' => 'Usuarios y roles',
                            'patron' => 'seguridad.usuarios.*',
                            'icono' => '<path stroke-linecap="round" stroke-linejoin="round" d="M18 18.72a9.094 9.094 0 003.741-.479 3 3 0 00-4.682-2.72m.94 3.198l.001.031c0 .225-.012.447-.037.666A11.944 11.944 0 0112 21c-2.17 0-4.207-.576-5.963-1.584A6.062 6.062 0 016 18.715m12 0v-.503a3.333 3.333 0 00-3-3.333h-6c-1.657 0-3 1.492-3 3.333v.503m6-9.5a3 3 0 11-6 0 3 3 0 016 0z"/>'
                        ],
                    ] as $item)

                        @php
                            $active = request()->routeIs($item['patron']);
                        @endphp

                        @if (Route::has($item['ruta']))
                            <a
                                href="{{ route($item['ruta']) }}"
                                @if($active) aria-current="page" @endif
                                :title="sidebarCollapsed ? '{{ $item['texto'] }}' : ''"
                                class="group flex items-center gap-3 py-2.5
                                    rounded-lg text-sm font-medium transition-colors"
                                :class="[
                                    sidebarCollapsed ? 'justify-center px-0' : 'px-3',
                                    {{ $active
                                        ? "'bg-primary-600 text-white shadow-sm'"
                                        : "'text-slate-300 hover:bg-slate-800 hover:text-white'"
                                    }}
                                ]"
                            >

                                <svg
                                    class="w-5 h-5 flex-shrink-0"
                                    fill="none"
                                    stroke="currentColor"
                                    stroke-width="1.5"
                                    viewBox="0 0 24 24"
                                    aria-hidden="true"
                                >
                                    {!! $item['icono'] !!}
                                </svg>

                                <span
                                    x-show="!sidebarCollapsed"
                                    x-transition
                                    class="whitespace-nowrap"
                                >
                                    {{ $item['texto'] }}
                                </span>

                            </a>
                        @endif

                    @endforeach

                    {{-- Volver a GEMAS --}}
                    <div class="border-t border-slate-800">

                        <a
                            href="{{ url('/dashboard') }}"
                            :title="sidebarCollapsed ? 'Volver a GEMAS' : ''"
                            class="group flex items-center gap-3 py-2.5 px-3
                                rounded-lg text-sm font-medium
                                text-slate-500 hover:bg-primary-50
                                hover:text-primary-700 transition-colors"
                            :class="sidebarCollapsed ? 'justify-center px-0' : 'px-3'"
                        >

                            <svg
                                class="w-5 h-5 flex-shrink-0"
                                fill="none"
                                stroke="currentColor"
                                stroke-width="1.5"
                                viewBox="0 0 24 24"
                                aria-hidden="true"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    d="M9 15L3 9m0 0l6-6M3 9h12a6 6 0 010 12h-3"
                                />
                            </svg>

                            <span
                                x-show="!sidebarCollapsed"
                                x-transition
                                class="whitespace-nowrap"
                            >
                                Volver a GEMAS
                            </span>

                        </a>

                    </div>

                </nav>

                {{-- Cerrar sesión --}}
                <div class="py-4 border-t border-slate-200 transition-all duration-300"
                    :class="sidebarCollapsed ? 'px-2' : 'px-3'">

                    <form
                        method="POST"
                        action="{{ Route::has('logout') ? route('logout') : '#' }}"
                    >
                        @csrf

                        <button
                            type="submit"
                            class="w-full flex items-center gap-3 py-2.5
                                rounded-lg text-sm font-medium
                                text-red-600 hover:bg-red-50
                                transition-all duration-300
                                focus:outline-none focus:ring-2
                                focus:ring-red-300"
                            :class="sidebarCollapsed ? 'justify-center px-0' : 'px-3'"
                            :title="sidebarCollapsed ? 'Cerrar sesión' : ''"
                            aria-label="Cerrar sesión"
                        >

                            <svg
                                class="w-5 h-5 flex-shrink-0"
                                fill="none"
                                viewBox="0 0 24 24"
                                stroke="currentColor"
                                aria-hidden="true"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"
                                />
                            </svg>

                            <span x-show="!sidebarCollapsed" x-transition>
                                Cerrar sesión
                            </span>

                        </button>
                    </form>

                </div>

            </div>
        </aside>

        {{-- Contenido --}}
        <div
            class="min-h-screen min-w-0 flex flex-col
                transition-all duration-300 ease-in-out"
            :class="sidebarCollapsed
                ? 'lg:ml-20 lg:w-[calc(100%-5rem)]'
                : 'lg:ml-64 lg:w-[calc(100%-16rem)]'"
        >

            {{-- Navbar principal de GEMAS --}}
            @include('layouts.partials.navbar')

            {{-- Contenido de las vistas --}}
            <main class="flex-1 w-full min-w-0 p-4 sm:p-6 lg:p-8 space-y-4">

                {{-- Mensaje de éxito --}}
                @if (session('success'))
                    <div class="rounded-lg bg-green-50 border border-green-200
                        text-green-800 px-4 py-3 text-sm shadow-sm">
                        {{ session('success') }}
                    </div>
                @endif

                {{-- Mensaje de error --}}
                @if (session('error'))
                    <div class="rounded-lg bg-red-50 border border-red-200
                        text-red-800 px-4 py-3 text-sm shadow-sm">
                        {{ session('error') }}
                    </div>
                @endif

                @yield('content')

            </main>

            {{-- Footer principal de GEMAS --}}
            @include('layouts.partials.footer')

        </div>

    </div>

    {{-- Alpine.js --}}
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.14.1/dist/cdn.min.js" defer></script>

    <script>
        window.addEventListener('pageshow', function (event) {
            if (event.persisted) {
                window.location.reload();
            }
        });
    </script>

    @stack('scripts')

</body>
</html>
