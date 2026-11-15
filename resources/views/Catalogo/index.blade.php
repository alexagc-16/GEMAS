<!DOCTYPE html>
@php
    // Número de WhatsApp con código de país, sin espacios ni signos.
    $whatsapp = '573124539172';
@endphp
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gemas | Adopta una mascota</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-[#F7FAF9] text-slate-800">

    {{-- NAVBAR --}}
    <header class="bg-white border-b border-slate-100">
        <nav class="max-w-7xl mx-auto px-6 py-5 flex items-center justify-between">

            <a href="{{ route('catalogo.index') }}" class="flex items-center gap-3">
                <img src="{{ asset('img/logo - sin.png') }}"
                    alt="Logo GEMAS"
                    class="w-16 h-16 object-contain">

                <div>
                    <img src="{{ asset('img/letras.png') }}"
                    alt="GEMAS"
                    class="h-8 w-auto object-contain">
                    <p class="text-[10px] tracking-[0.2em] text-slate-400 font-semibold">
                        AMOR Y CUIDADO ANIMAL
                    </p>
                </div>
            </a>

            <div class="hidden md:flex items-center gap-9 text-sm font-semibold text-slate-600">
                <a href="#inicio" class="hover:text-gemas-600 transition">Inicio</a>
                <a href="#mascotas" class="hover:text-gemas-600 transition">Adopta</a>
                <a href="#donaciones" class="hover:text-gemas-600 transition">Donaciones</a>
            </div>

            <div class="flex flex-col-reverse gap-3 border-t border-slate-100 bg-slate-50/70 px-6 py-4 sm:flex-row sm:justify-end">

                <a href="{{ route('registro') }}"
                    class="inline-flex items-center justify-center rounded-lg border border-slate-400 bg-white px-5 py-2.5 text-sm font-semibold text-slate-700 transition hover:bg-slate-100">
                    Registrarse
                </a>

                <a href="{{ route('login') }}"
                    class="inline-flex items-center justify-center rounded-lg bg-teal-700 px-5 py-2.5 text-sm font-semibold text-white transition hover:bg-teal-800 focus:outline-none focus:ring-2 focus:ring-teal-500 focus:ring-offset-2">
                    Ingresar al sistema
                </a>

            </div>
        </nav>
    </header>


    {{-- PORTADA --}}
    <main>

        <section id="inicio" class="max-w-7xl mx-auto px-5 pt-8">

            <div class="relative min-h-[490px] md:min-h-[550px] rounded-[2rem] overflow-hidden
                        flex items-center bg-slate-900">

                <img src="{{ asset('img/catalogo/portada-mascotas.jpg') }}"
                    alt="Perros y gatos esperando un hogar"
                    class="absolute inset-0 w-full h-full object-cover">

                <div class="absolute inset-0 bg-gradient-to-r
                            from-slate-950/90 via-slate-950/60 to-transparent"></div>

                <div class="relative z-10 max-w-2xl px-8 py-16 md:px-16 md:py-20">

                    <span class="inline-flex items-center gap-2 bg-white/15
                                 border border-white/20 text-white px-4 py-2
                                 rounded-full text-xs font-semibold mb-7">
                        <span class="w-2 h-2 bg-gemas-400 rounded-full"></span>
                        CADA MASCOTA MERECE UNA OPORTUNIDAD
                    </span>

                    <h2 class="text-4xl md:text-6xl font-extrabold text-white
                               leading-[1.12] mb-6">
                        Un hogar puede
                        <span class="text-gemas-300">cambiarlo todo.</span>
                    </h2>

                    <p class="text-slate-200 text-base md:text-lg leading-relaxed
                              max-w-lg mb-9">
                        Hay una mascota esperando encontrar una familia que la
                        quiera. Conoce nuestros pequeños amigos y dale una
                        oportunidad a una nueva historia.
                    </p>

                    <div class="flex flex-wrap gap-4">
                        <a href="#mascotas"
                            class="bg-gemas-500 hover:bg-gemas-400 text-white
                                   px-7 py-4 rounded-xl font-bold transition">
                            Conocer mascotas
                        </a>

                        <a href="#donaciones"
                            class="bg-white/10 hover:bg-white/20 border border-white/40
                                   text-white px-7 py-4 rounded-xl font-bold transition">
                            Quiero donar
                        </a>
                    </div>
                </div>
            </div>
        </section>


        {{-- CATÁLOGO --}}
        <section id="mascotas" class="max-w-7xl mx-auto px-5 py-20">

            <div class="flex flex-col md:flex-row md:items-end
                        justify-between gap-5 mb-10">

                <div>
                    <span class="text-gemas-600 text-sm font-bold uppercase tracking-widest">
                        Encuentra a tu compañero
                    </span>

                    <h2 class="text-3xl md:text-4xl font-extrabold text-slate-800 mt-3">
                        Mascotas en adopción
                    </h2>

                    <p class="text-slate-500 mt-3 max-w-xl">
                        Conoce a nuestros amigos que buscan una familia
                        donde recibir mucho amor.
                    </p>
                </div>

                <span class="text-sm text-slate-500 font-medium">
                    Un nuevo comienzo empieza contigo.
                </span>
            </div>


            
            {{-- BUSCADOR Y FILTROS --}}
            <div class="bg-white rounded-2xl border border-slate-200
                        shadow-sm p-5 mb-10">

                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">

                    {{-- Buscar por nombre --}}
                    <div>
                        <label class="block text-xs font-bold text-slate-600 mb-2">
                            Buscar mascota
                        </label>

                        <div class="relative">
                            <svg class="w-5 h-5 absolute left-4 top-1/2
                                        -translate-y-1/2 text-slate-400"
                                fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <circle cx="11" cy="11" r="7" stroke-width="2"/>
                                <path stroke-linecap="round" stroke-width="2"
                                    d="m16 16 4 4"/>
                            </svg>

                            <input type="text"
                                id="buscarMascota"
                                placeholder="Nombre de la mascota..."
                                class="w-full pl-12 pr-4 py-3 rounded-xl border
                                    border-slate-200 bg-slate-50 text-sm
                                    focus:ring-2 focus:ring-gemas-500
                                    focus:border-gemas-500 outline-none">
                        </div>
                    </div>

                    {{-- Filtrar por especie --}}
                    <div>
                        <label class="block text-xs font-bold text-slate-600 mb-2">
                            Especie
                        </label>

                        <select id="filtroEspecie"
                            class="w-full px-4 py-3 rounded-xl border
                                border-slate-200 bg-slate-50 text-sm
                                outline-none focus:ring-2 focus:ring-gemas-500">

                            <option value="">Todas las especies</option>
                            <option value="perro">Perro</option>
                            <option value="gato">Gato</option>
                        </select>
                    </div>

                    {{-- Filtrar por sexo --}}
                    <div>
                        <label class="block text-xs font-bold text-slate-600 mb-2">
                            Sexo
                        </label>

                        <select id="filtroSexo"
                            class="w-full px-4 py-3 rounded-xl border
                                border-slate-200 bg-slate-50 text-sm
                                outline-none focus:ring-2 focus:ring-gemas-500">

                            <option value="">Todos</option>
                            <option value="macho">Macho</option>
                            <option value="hembra">Hembra</option>
                        </select>
                    </div>

                    {{-- Botón buscar --}}
                    <div class="flex items-end">
                        <button type="button"
                            id="btnBuscarMascotas"
                            class="w-full bg-gemas-600 hover:bg-gemas-700
                                text-white py-3 rounded-xl font-bold
                                text-sm transition">
                            Buscar mascotas
                        </button>
                    </div>

                </div>
            </div>

            {{-- CONTADOR DE RESULTADOS --}}
            <p id="contadorMascotas" class="text-sm text-slate-500 mb-6">
                Mostrando todas las mascotas.
            </p>



            
            {{-- TARJETAS --}}
            <div id="contenedorMascotas"
                class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">

                {{-- MASCOTA 1: MAX --}}
                <article data-mascota
                    data-especie="perro"
                    data-sexo="macho"
                    class="bg-white rounded-3xl overflow-hidden
                        border border-slate-100 shadow-sm
                        hover:shadow-xl hover:-translate-y-1
                        transition duration-300">

                    <div class="relative h-72 overflow-hidden">
                        <img src="{{ asset('img/catalogo/mascota-1.jpg') }}"
                            alt="Max, perro en adopción"
                            class="w-full h-full object-contain hover:scale-105 transition duration-500">

                        <span class="absolute top-4 left-4 bg-gemas-600 text-white
                                    text-xs font-bold px-4 py-2 rounded-full">
                            En adopción
                        </span>
                    </div>

                    <div class="p-6">
                        <div class="flex items-center justify-between mb-3">
                            <h3 class="text-2xl font-extrabold text-slate-800">Max</h3>

                            <span class="text-xs font-semibold text-gemas-700
                                        bg-gemas-50 px-3 py-2 rounded-full">
                                Perro
                            </span>
                        </div>

                        <p class="text-sm text-slate-500 mb-5">
                            Un compañero alegre, cariñoso y lleno de energía.
                        </p>

                        <div class="flex gap-5 text-sm text-slate-500
                                    border-t border-slate-100 pt-4 mb-6">
                            <span>♂ Macho</span>
                            <span>2 años</span>
                        </div>

                        <a href="https://wa.me/57NUMERO?text=Hola,%20estoy%20interesado%20en%20adoptar%20a%20Max."
                            target="_blank" rel="noopener noreferrer"
                            class="block text-center bg-gemas-50 hover:bg-gemas-600
                                text-gemas-700 hover:text-white font-bold
                                py-3 rounded-xl transition">
                            Me interesa
                        </a>
                    </div>
                </article>


                {{-- MASCOTA 2: LUNA --}}
                <article data-mascota
                    data-especie="gato"
                    data-sexo="hembra"
                    class="bg-white rounded-3xl overflow-hidden
                        border border-slate-100 shadow-sm
                        hover:shadow-xl hover:-translate-y-1
                        transition duration-300">

                    <div class="relative h-72 overflow-hidden">
                        <img src="{{ asset('img/catalogo/mascota-2.jpg') }}"
                            alt="Luna, gata en adopción"
                            class="w-full h-full object-contain hover:scale-105 transition duration-500">

                        <span class="absolute top-4 left-4 bg-gemas-600 text-white
                                    text-xs font-bold px-4 py-2 rounded-full">
                            En adopción
                        </span>
                    </div>

                    <div class="p-6">
                        <div class="flex items-center justify-between mb-3">
                            <h3 class="text-2xl font-extrabold text-slate-800">Luna</h3>

                            <span class="text-xs font-semibold text-gemas-700
                                        bg-gemas-50 px-3 py-2 rounded-full">
                                Gato
                            </span>
                        </div>

                        <p class="text-sm text-slate-500 mb-5">
                            Una pequeña dulce y tranquila que busca compañía.
                        </p>

                        <div class="flex gap-5 text-sm text-slate-500
                                    border-t border-slate-100 pt-4 mb-6">
                            <span>♀ Hembra</span>
                            <span>1 año</span>
                        </div>

                        <a href="https://wa.me/57NUMERO?text=Hola,%20estoy%20interesado%20en%20adoptar%20a%20Luna."
                            target="_blank" rel="noopener noreferrer"
                            class="block text-center bg-gemas-50 hover:bg-gemas-600
                                text-gemas-700 hover:text-white font-bold
                                py-3 rounded-xl transition">
                            Me interesa
                        </a>
                    </div>
                </article>


                {{-- MASCOTA 3: ROCKY --}}
                <article data-mascota
                    data-especie="perro"
                    data-sexo="macho"
                    class="bg-white rounded-3xl overflow-hidden
                        border border-slate-100 shadow-sm
                        hover:shadow-xl hover:-translate-y-1
                        transition duration-300">

                    <div class="relative h-72 overflow-hidden">
                        <img src="{{ asset('img/catalogo/mascota-3.jpg') }}"
                            alt="Rocky, perro en adopción"
                            class="w-full h-full object-contain hover:scale-105 transition duration-500">

                        <span class="absolute top-4 left-4 bg-gemas-600 text-white
                                    text-xs font-bold px-4 py-2 rounded-full">
                            En adopción
                        </span>
                    </div>

                    <div class="p-6">
                        <div class="flex items-center justify-between mb-3">
                            <h3 class="text-2xl font-extrabold text-slate-800">Rocky</h3>

                            <span class="text-xs font-semibold text-gemas-700
                                        bg-gemas-50 px-3 py-2 rounded-full">
                                Perro
                            </span>
                        </div>

                        <p class="text-sm text-slate-500 mb-5">
                            Un amigo fiel, juguetón y listo para conocer su hogar.
                        </p>

                        <div class="flex gap-5 text-sm text-slate-500
                                    border-t border-slate-100 pt-4 mb-6">
                            <span>♂ Macho</span>
                            <span>4 años</span>
                        </div>

                        <a href="https://wa.me/57NUMERO?text=Hola,%20estoy%20interesado%20en%20adoptar%20a%20Rocky."
                            target="_blank" rel="noopener noreferrer"
                            class="block text-center bg-gemas-50 hover:bg-gemas-600
                                text-gemas-700 hover:text-white font-bold
                                py-3 rounded-xl transition">
                            Me interesa
                        </a>
                    </div>
                </article>


                {{-- MASCOTA 4: BELLA --}}
                <article data-mascota
                    data-especie="perro"
                    data-sexo="hembra"
                    class="bg-white rounded-3xl overflow-hidden
                        border border-slate-100 shadow-sm
                        hover:shadow-xl hover:-translate-y-1
                        transition duration-300">

                    <div class="relative h-72 overflow-hidden">
                        <img src="{{ asset('img/catalogo/mascota-1.jpg') }}"
                            alt="Bella, perrita en adopción"
                            class="w-full h-full object-contain hover:scale-105 transition duration-500">

                        <span class="absolute top-4 left-4 bg-gemas-600 text-white
                                    text-xs font-bold px-4 py-2 rounded-full">
                            En adopción
                        </span>
                    </div>

                    <div class="p-6">
                        <div class="flex items-center justify-between mb-3">
                            <h3 class="text-2xl font-extrabold text-slate-800">Bella</h3>

                            <span class="text-xs font-semibold text-gemas-700
                                        bg-gemas-50 px-3 py-2 rounded-full">
                                Perro
                            </span>
                        </div>

                        <p class="text-sm text-slate-500 mb-5">
                            Una compañera cariñosa que espera una familia.
                        </p>

                        <div class="flex gap-5 text-sm text-slate-500
                                    border-t border-slate-100 pt-4 mb-6">
                            <span>♀ Hembra</span>
                            <span>3 años</span>
                        </div>

                        <a href="https://wa.me/57NUMERO?text=Hola,%20estoy%20interesado%20en%20adoptar%20a%20Bella."
                            target="_blank" rel="noopener noreferrer"
                            class="block text-center bg-gemas-50 hover:bg-gemas-600
                                text-gemas-700 hover:text-white font-bold
                                py-3 rounded-xl transition">
                            Me interesa
                        </a>
                    </div>
                </article>


                {{-- MASCOTA 5: SIMBA --}}
                <article data-mascota
                    data-especie="gato"
                    data-sexo="macho"
                    class="bg-white rounded-3xl overflow-hidden
                        border border-slate-100 shadow-sm
                        hover:shadow-xl hover:-translate-y-1
                        transition duration-300">

                    <div class="relative h-72 overflow-hidden">
                        <img src="{{ asset('img/catalogo/mascota-2.jpg') }}"
                            alt="Simba, gato en adopción"
                            class="w-full h-full object-contain hover:scale-105 transition duration-500">

                        <span class="absolute top-4 left-4 bg-gemas-600 text-white
                                    text-xs font-bold px-4 py-2 rounded-full">
                            En adopción
                        </span>
                    </div>

                    <div class="p-6">
                        <div class="flex items-center justify-between mb-3">
                            <h3 class="text-2xl font-extrabold text-slate-800">Simba</h3>

                            <span class="text-xs font-semibold text-gemas-700
                                        bg-gemas-50 px-3 py-2 rounded-full">
                                Gato
                            </span>
                        </div>

                        <p class="text-sm text-slate-500 mb-5">
                            Un pequeño curioso, juguetón y lleno de ternura.
                        </p>

                        <div class="flex gap-5 text-sm text-slate-500
                                    border-t border-slate-100 pt-4 mb-6">
                            <span>♂ Macho</span>
                            <span>2 años</span>
                        </div>

                        <a href="https://wa.me/57NUMERO?text=Hola,%20estoy%20interesado%20en%20adoptar%20a%20Simba."
                            target="_blank" rel="noopener noreferrer"
                            class="block text-center bg-gemas-50 hover:bg-gemas-600
                                text-gemas-700 hover:text-white font-bold
                                py-3 rounded-xl transition">
                            Me interesa
                        </a>
                    </div>
                </article>


                {{-- MASCOTA 6: NALA --}}
                <article data-mascota
                    data-especie="gato"
                    data-sexo="hembra"
                    class="bg-white rounded-3xl overflow-hidden
                        border border-slate-100 shadow-sm
                        hover:shadow-xl hover:-translate-y-1
                        transition duration-300">

                    <div class="relative h-72 overflow-hidden">
                        <img src="{{ asset('img/catalogo/mascota-3.jpg') }}"
                            alt="Nala, gata en adopción"
                            class="w-full h-full object-contain hover:scale-105 transition duration-500">

                        <span class="absolute top-4 left-4 bg-gemas-600 text-white
                                    text-xs font-bold px-4 py-2 rounded-full">
                            En adopción
                        </span>
                    </div>

                    <div class="p-6">
                        <div class="flex items-center justify-between mb-3">
                            <h3 class="text-2xl font-extrabold text-slate-800">Nala</h3>

                            <span class="text-xs font-semibold text-gemas-700
                                        bg-gemas-50 px-3 py-2 rounded-full">
                                Gato
                            </span>
                        </div>

                        <p class="text-sm text-slate-500 mb-5">
                            Una gatita dulce y tranquila que busca un hogar.
                        </p>

                        <div class="flex gap-5 text-sm text-slate-500
                                    border-t border-slate-100 pt-4 mb-6">
                            <span>♀ Hembra</span>
                            <span>1 año</span>
                        </div>

                        <a href="https://wa.me/57NUMERO?text=Hola,%20estoy%20interesado%20en%20adoptar%20a%20Nala."
                            target="_blank" rel="noopener noreferrer"
                            class="block text-center bg-gemas-50 hover:bg-gemas-600
                                text-gemas-700 hover:text-white font-bold
                                py-3 rounded-xl transition">
                            Me interesa
                        </a>
                    </div>
                </article>

            </div>

            {{-- PAGINACIÓN --}}
            <div id="paginacion"
                class="flex justify-center items-center flex-wrap gap-2 mt-10">
            </div>

            {{-- MENSAJE CUANDO NO HAY RESULTADOS --}}
            <div id="sinResultados" class="hidden text-center py-12">
                <p class="text-lg font-bold text-slate-700">
                    No encontramos mascotas.
                </p>

                <p class="text-sm text-slate-500 mt-2">
                    Intenta cambiar los filtros de búsqueda.
                </p>
            </div>

            <div class="text-center mt-12">
                <p class="text-sm text-slate-500">
                    ¿No encontraste a tu compañero ideal? Pronto habrá más mascotas.
                </p>
            </div>

        </section>


        {{-- DONACIONES --}}
        <section id="donaciones" class="bg-[#EAF4F5] py-16">

            <div class="max-w-7xl mx-auto px-5">
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-12
                            items-center">

                    <div class="rounded-3xl overflow-hidden h-80 lg:h-[390px]">
                        <img src="{{ asset('img/catalogo/donaciones.jpg') }}"
                            alt="Ayuda a las mascotas"
                            class="w-full h-full object-contain">
                    </div>

                    <div>
                        <span class="text-gemas-700 text-sm font-bold
                                     tracking-widest uppercase">
                            Tu ayuda hace la diferencia
                        </span>

                        <h2 class="text-3xl md:text-4xl font-extrabold
                                   text-slate-800 mt-4 mb-5 leading-tight">
                            Pequeñas ayudas pueden cambiar muchas vidas.
                        </h2>

                        <p class="text-slate-600 leading-relaxed mb-7">
                            Con tu colaboración podemos brindar alimento,
                            atención y bienestar a las mascotas que más lo
                            necesitan. Cada aporte cuenta.
                        </p>

                        <a href="https://wa.me/573124539172?text=Hola,%20quiero%20informacion%20sobre%20como%20puedo%20realizar%20una%20donacion%20para%20ayudar%20a%20las%20mascotas."
                            target="_blank"
                            rel="noopener noreferrer"
                            class="inline-flex items-center gap-3 bg-gemas-600
                                hover:bg-gemas-700 text-white px-7 py-4
                                rounded-xl font-bold transition">
                            Quiero colaborar

                            <svg class="w-5 h-5" fill="none"
                                stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    stroke-width="2" d="M5 12h14m-7-7 7 7-7 7"/>
                            </svg>
                        </a>
                    </div>

                </div>
            </div>
        </section>

    </main>


    {{-- FOOTER --}}
    <footer class="bg-slate-900 text-white py-10">

        <div class="max-w-7xl mx-auto px-5">

            <div class="flex flex-col md:flex-row justify-between
                        items-center gap-6">

                <div>
                    <img src="{{ asset('img/letras.png') }}"
                    alt="GEMAS"
                    class="h-8 w-auto object-contain">
                    <p class="text-slate-400 text-sm mt-2">
                        Promoviendo el bienestar y cuidado animal.
                    </p>
                </div>

                <div class="flex flex-wrap justify-center gap-6
                            text-sm text-slate-300">
                    <a href="#inicio" class="hover:text-gemas-400">Inicio</a>
                    <a href="#mascotas" class="hover:text-gemas-400">Adopta</a>
                    <a href="#donaciones" class="hover:text-gemas-400">Donaciones</a>
                    <a href="{{ route('login') }}" class="hover:text-gemas-400">Ingresar</a>
                </div>

            </div>

            <div class="border-t border-slate-700 mt-8 pt-6 text-center">
                <p class="text-xs text-slate-500">
                    © {{ date('Y') }} GEMAS. Todos los derechos reservados.
                </p>
            </div>

        </div>
    </footer>

    
    <script>
        document.addEventListener('DOMContentLoaded', function () {

            // Elementos de los filtros
            const buscarMascota = document.getElementById('buscarMascota');
            const filtroEspecie = document.getElementById('filtroEspecie');
            const filtroSexo = document.getElementById('filtroSexo');
            const btnBuscarMascotas = document.getElementById('btnBuscarMascotas');

            // Elementos del catálogo
            const contadorMascotas = document.getElementById('contadorMascotas');
            const sinResultados = document.getElementById('sinResultados');
            const contenedorPaginacion = document.getElementById('paginacion');

            // Todas las tarjetas registradas en el HTML
            const tarjetas = Array.from(
                document.querySelectorAll('[data-mascota]')
            );

            // Configuración dinámica de la paginación
            function obtenerMascotasPorPagina() {
                return window.innerWidth < 1024 ? 4 : 3;
            }

            let mascotasPorPagina = obtenerMascotasPorPagina();

            let paginaActual = 1;
            let mascotasFiltradas = [...tarjetas];

            // Aplicar filtros
            function filtrarMascotas() {

                const nombre = buscarMascota.value.trim().toLowerCase();
                const especie = filtroEspecie.value;
                const sexo = filtroSexo.value;

                mascotasFiltradas = tarjetas.filter(function (tarjeta) {

                    const nombreMascota = tarjeta.querySelector('h3')
                        .textContent.trim().toLowerCase();

                    const especieMascota = tarjeta.dataset.especie;
                    const sexoMascota = tarjeta.dataset.sexo;

                    const coincideNombre = nombreMascota.includes(nombre);

                    const coincideEspecie =
                        especie === '' || especieMascota === especie;

                    const coincideSexo =
                        sexo === '' || sexoMascota === sexo;

                    return coincideNombre && coincideEspecie && coincideSexo;
                });

                // Volver a la primera página al cambiar los filtros
                paginaActual = 1;

                mostrarMascotas();
            }

            // Mostrar las mascotas correspondientes a la página
            function mostrarMascotas() {

                const totalMascotas = mascotasFiltradas.length;

                const totalPaginas = Math.ceil(
                    totalMascotas / mascotasPorPagina
                );

                // Evitar páginas inexistentes
                if (paginaActual > totalPaginas) {
                    paginaActual = Math.max(1, totalPaginas);
                }

                const inicio = (paginaActual - 1) * mascotasPorPagina;
                const fin = inicio + mascotasPorPagina;

                // Ocultar todas las tarjetas inicialmente
                tarjetas.forEach(function (tarjeta) {
                    tarjeta.classList.add('hidden');
                });

                // Mostrar únicamente las mascotas de la página actual
                const mascotasPagina = mascotasFiltradas.slice(inicio, fin);

                mascotasPagina.forEach(function (tarjeta) {
                    tarjeta.classList.remove('hidden');
                });

                // Actualizar contador
                contadorMascotas.textContent =
                    `Mostrando ${totalMascotas === 0 ? 0 : inicio + 1} - ${Math.min(fin, totalMascotas)} de ${totalMascotas} mascotas.`;

                // Mostrar u ocultar mensaje sin resultados
                sinResultados.classList.toggle(
                    'hidden',
                    totalMascotas !== 0
                );

                // Dibujar controles de paginación
                generarPaginacion(totalPaginas);
            }

            // Generar botones de paginación
            function generarPaginacion(totalPaginas) {

                contenedorPaginacion.innerHTML = '';

                // No mostrar paginación si solo hay una página
                if (totalPaginas <= 1) {
                    return;
                }

                // Botón anterior
                const botonAnterior = document.createElement('button');

                botonAnterior.type = 'button';
                botonAnterior.textContent = 'Anterior';

                botonAnterior.className =
                    'px-4 py-2 rounded-lg border border-gemas-200 ' +
                    'text-gemas-700 hover:bg-gemas-50 text-sm font-semibold ' +
                    'disabled:opacity-40 disabled:cursor-not-allowed';

                botonAnterior.disabled = paginaActual === 1;

                botonAnterior.addEventListener('click', function () {
                    paginaActual--;
                    mostrarMascotas();
                });

                contenedorPaginacion.appendChild(botonAnterior);

                // Botones numerados
                for (let pagina = 1; pagina <= totalPaginas; pagina++) {

                    const boton = document.createElement('button');

                    boton.type = 'button';
                    boton.textContent = pagina;

                    boton.className =
                        'w-10 h-10 rounded-lg text-sm font-bold transition ' +
                        (pagina === paginaActual
                            ? 'bg-gemas-600 text-white'
                            : 'bg-white border border-gemas-200 text-gemas-700 hover:bg-gemas-50');

                    boton.addEventListener('click', function () {
                        paginaActual = pagina;
                        mostrarMascotas();
                    });

                    contenedorPaginacion.appendChild(boton);
                }

                // Botón siguiente
                const botonSiguiente = document.createElement('button');

                botonSiguiente.type = 'button';
                botonSiguiente.textContent = 'Siguiente';

                botonSiguiente.className =
                    'px-4 py-2 rounded-lg border border-gemas-200 ' +
                    'text-gemas-700 hover:bg-gemas-50 text-sm font-semibold ' +
                    'disabled:opacity-40 disabled:cursor-not-allowed';

                botonSiguiente.disabled = paginaActual === totalPaginas;

                botonSiguiente.addEventListener('click', function () {
                    paginaActual++;
                    mostrarMascotas();
                });

                contenedorPaginacion.appendChild(botonSiguiente);
            }

            // Eventos de los filtros
            buscarMascota.addEventListener('input', filtrarMascotas);

            filtroEspecie.addEventListener('change', filtrarMascotas);

            filtroSexo.addEventListener('change', filtrarMascotas);

            btnBuscarMascotas.addEventListener('click', filtrarMascotas);

            // Mostrar catálogo inicialmente
            mostrarMascotas();

            // Actualizar cantidad de mascotas al cambiar el tamaño de pantalla
            window.addEventListener('resize', function () {

                const nuevaCantidad = obtenerMascotasPorPagina();

                if (nuevaCantidad !== mascotasPorPagina) {

                    mascotasPorPagina = nuevaCantidad;

                    paginaActual = 1;

                    mostrarMascotas();
                }
            });

        });
    </script>


</body>
</html>


