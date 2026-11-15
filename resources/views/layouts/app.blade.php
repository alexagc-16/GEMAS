<!DOCTYPE html>
<html lang="es" class="h-full bg-slate-50">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Gemas') - {{ config('app.name', 'Admin') }}</title>

    {{-- Tailwind CSS. Reemplazar por tu build de Vite/PostCSS en producción (ver README). --}}
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
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    {{-- Chart.js (solo se usa donde se necesita) --}}
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.4/dist/chart.umd.min.js" defer></script>

    <style>
        [x-cloak] { display: none !important; }
        body { font-family: 'Inter', ui-sans-serif, system-ui, sans-serif; }
    </style>

    @stack('styles')
</head>
<body class="h-full text-slate-800 antialiased">

    {{-- CONTENEDOR PRINCIPAL: estado compartido --}}
    <div
        x-data="{
            sidebarOpen: false,
            sidebarCollapsed: false
        }"
        class="min-h-screen"
    >

        {{-- Overlay móvil --}}
        <div
            x-show="sidebarOpen"
            x-cloak
            @click="sidebarOpen = false"
            class="fixed inset-0 z-30 bg-slate-900/50 lg:hidden"
            aria-hidden="true"
        ></div>


        @include('layouts.partials.sidebar')

        <div class="min-h-screen min-w-0 flex flex-col transition-all duration-300 ease-in-out"
            :class="sidebarCollapsed
                ? 'lg:ml-20 lg:w-[calc(100%-5rem)]'
                : 'lg:ml-64 lg:w-[calc(100%-16rem)]'">

            @include('layouts.partials.navbar')

            <main class="flex-1 w-full min-w-0 p-4 sm:p-6 lg:p-8">

                @yield('content')
            </main>

            @include('layouts.partials.footer')
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.14.1/dist/cdn.min.js" defer></script>

    <!-- AUTOMATIZACIÓN DE LA HORA DEL CELULAR -->
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            // 1. Detecta automáticamente la zona horaria del celular (ej: America/Bogota o America/New_York)
            const timezone = Intl.DateTimeFormat().resolvedOptions().timeZone;
            
            // 2. Almacena el valor en una cookie válida por 7 días
            let date = new Date();
            date.setTime(date.getTime() + (7 * 24 * 60 * 60 * 1000));
            document.cookie = "device_timezone=" + timezone + "; expires=" + date.toUTCString() + "; path=/; SameSite=Lax";
        });
    </script>

    @stack('scripts')
</body>
</html>
