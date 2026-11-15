
<!DOCTYPE html>
<html lang="es" class="h-full bg-slate-50">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>@yield('title', 'Seguridad') - {{ config('app.name') }}</title>

    {{-- Tailwind CSS --}}
    <script src="https://cdn.tailwindcss.com"></script>

    {{-- Colores GEMAS --}}
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
        body {
            font-family: 'Inter', ui-sans-serif, system-ui, sans-serif;
        }
    </style>

    @stack('styles')
</head>

<body class="h-full text-slate-800 antialiased">

    @yield('content')

    @stack('scripts')

</body>
</html>
