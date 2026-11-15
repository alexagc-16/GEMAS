{{--
    Sidebar principal.
    Usa la variable de ruta actual (Route::currentRouteName() o request()->routeIs())
    para resaltar el enlace activo.
--}}
{{--< x-data="{
    sidebarOpen: false,
    sidebarCollapsed: false
}">--}}

    <aside
        x-cloak
        :class="[
            sidebarOpen ? 'translate-x-0' : '-translate-x-full lg:translate-x-0',
            sidebarCollapsed ? 'lg:w-20' : 'lg:w-64'
        ]"
        class="fixed inset-y-0 left-0 z-40
            w-64 bg-slate-900 text-slate-300
            transform transition-all duration-300 ease-in-out
            lg:translate-x-0"
        aria-label="Menú principal">

        <div class="h-full flex flex-col">

            {{-- Logo --}}
            <div class="flex items-center justify-center h-28
                    border-b border-slate-800 transition-all duration-300"
                :class="sidebarCollapsed ? 'px-2' : 'px-4'"
            >
                <button
                    type="button"
                    @click="sidebarCollapsed = !sidebarCollapsed"
                    class="flex items-center justify-center w-full h-full
                    rounded-lg border-0 outline-none
                    hover:bg-transparent
                    focus:outline-none focus:ring-0 focus:border-0
                    active:outline-none active:ring-0
                    transition-all duration-300"
                    :title="sidebarCollapsed ? 'Expandir menú' : 'Contraer menú'"
                    aria-label="Contraer o expandir menú"
                >

                    {{-- Logo cuando el menú está expandido --}}
                    <img
                        x-show="!sidebarCollapsed"
                        x-transition
                        src="{{ asset('img/logo.png') }}"
                        alt="GEMAS"
                        class="w-[95px] h-[95px] object-contain"
                    >

                    {{-- Logo cuando el menú está contraído --}}
                    <img
                        x-show="sidebarCollapsed"
                        x-transition
                        src="{{ asset('img/logo.png') }}"
                        alt="GEMAS"
                        class="w-12 h-12 object-contain"
                    >

                </button>
            </div>

            {{-- Navegación --}}
            <nav
                class="flex-1 overflow-y-auto
                    [scrollbar-width:none]
                    [&::-webkit-scrollbar]:hidden
                    py-6 space-y-1 transition-all duration-300"
                :class="sidebarCollapsed ? 'px-2' : 'px-3'"
                aria-label="Navegación lateral"
            >

                @php
                    $links = [
                        [
                            'label' => 'Inicio',   
                            'route' => 'dashboard.index',  
                            'icon' => 'home',
                            'can' => []
                            ],

                        [
                            'label' => 'Usuarios',    
                            'route' => 'usuario.index',      
                            'icon' => 'usuario',
                            'can' => ['ver usuarios']
                            ],

                        [
                            'label' => 'Mascotas',  
                            'route' => 'mascota.index', 
                            'icon' => 'mascota',
                            'can' => ['ver mascota']
                            ],

                        [
                            'label' => 'Historia Clinica',   
                            'route' => 'historiaclinica.index',   
                            'icon' => 'historiaclinica',
                            'can' => ['ver historiaclinica']
                            ],

                        [
                            'label' => 'Veterinarios', 
                            'route' => 'veterinario.index', 
                            'icon' => 'veterinario',
                            'can' => ['ver veterinario']
                            ],

                        [
                            'label' => 'Servicios',    
                            'route' => 'servicio.index',    
                            'icon' => 'servicio',
                            'can' => ['ver servicio']
                            ],

                        [
                            'label' => 'Horarios', 
                            'route' => 'horario.index', 
                            'icon' => 'horario',
                            'can' => ['ver horario']
                            ],

                        [
                            'label' => 'Citas', 
                            'route' => 'cita.index', 
                            'icon' => 'cita',
                            'can' => ['ver cita']
                            ],

                        [
                            'label' => 'Gestion Usuarios',
                            'route' => 'seguridad.permisos.index',
                            'icon' => 'gestion',
                            'can' => ['gestionar seguridad'],
                            ],

                    ];
                @endphp

                @foreach ($links as $link)
                    @continue(
                        !empty($link['can']) &&
                        (!auth()->check() || !auth()->user()->canAny($link['can']))
                    )
                    @php
                        $active = Route::has($link['route']) && request()->routeIs(explode('.', $link['route'])[0] . '.*');
                    @endphp
                    <a
                        href="{{ Route::has($link['route']) ? route($link['route']) : '#' }}"
                        @if($active) aria-current="page" @endif
                        class="group flex items-center gap-3 py-2.5
                        rounded-lg text-sm font-medium transition-colors
                        {{ $active
                        ? 'bg-primary-600 text-white shadow-sm'
                        : 'text-slate-300 hover:bg-slate-800
                        hover:text-white' }}"
                        :class="sidebarCollapsed ? 'justify-center px-0' : 'px-3'"
                    >
                        <span class="w-5 h-5 flex-shrink-0" ariahidden="true">
                        @include('layouts.partials.icons', ['icon' =>
                        $link['icon']])
                        </span>
                        <span x-show="!sidebarCollapsed" x-transition class="whitespace-nowrap">{{ $link['label'] }}</span>
                    </a>
                @endforeach

            </nav>

            {{-- Cerrar sesión --}}
            <div
                class="py-4 border-t border-slate-800 transition-all duration-300"
                :class="sidebarCollapsed ? 'px-2' : 'px-3'"
            >

                <form
                    method="POST"
                    action="{{ Route::has('logout') ? route('logout') : '#' }}"
                >
                    @csrf

                    <button
                        type="submit"
                        class="w-full flex items-center gap-3 py-2.5 rounded-lg
                            text-sm font-medium text-slate-300
                            hover:bg-slate-800 hover:text-white
                            transition-all duration-300
                            focus:outline-none focus:ring-2
                            focus:ring-primary-500"

                        :class="sidebarCollapsed
                            ? 'justify-center px-0'
                            : 'px-3'"

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

                        <span
                            x-show="!sidebarCollapsed"
                            x-transition
                            class="whitespace-nowrap"
                        >
                            Cerrar sesión
                        </span>

                    </button>
                </form>

            </div>


        </div>
    </aside>
