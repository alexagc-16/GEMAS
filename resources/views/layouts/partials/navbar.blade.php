<header class="sticky top-0 z-20 bg-white border-b border-slate-200">
    <div class="h-16 px-4 sm:px-6 lg:px-8 flex items-center justify-between gap-4">

        <div class="flex items-center gap-4 min-w-0">
            {{-- Botón menú móvil --}}
            <button
                @click="sidebarOpen = !sidebarOpen"
                type="button"
                class="lg:hidden p-2 rounded-lg text-slate-500 hover:bg-slate-100 hover:text-slate-700 focus:outline-none focus:ring-2 focus:ring-primary-500"
                aria-label="Abrir menú lateral"
            >
                <span class="w-6 h-6 block">@include('layouts.partials.icons', ['icon' => 'menu'])</span>
            </button>

        </div>

        <div class="flex items-center gap-2 sm:gap-4">

            {{-- Buscador --}}
            <form method="GET" action="{{ url()->current() }}" class="relative hidden md:block" role="search">
                <label for="global-search" class="sr-only">Buscar</label>
                <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-slate-400 w-4 h-4 pointer-events-none">
                    @include('layouts.partials.icons', ['icon' => 'search'])
                </span>
                <input
                    id="global-search"
                    type="search"
                    name="q"
                    value="{{ request('q') }}"
                    placeholder="Buscar..."
                    class="w-56 lg:w-72 pl-9 pr-3 py-2 text-sm rounded-lg border border-slate-200 bg-slate-50 focus:bg-white focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-transparent transition"
                >
            </form>

            {{-- Notificaciones --}}
            <div x-data="{ open: false }" class="relative">
                <button
                    @click="open = !open"
                    @click.outside="open = false"
                    type="button"
                    class="relative p-2 rounded-lg text-slate-500 hover:bg-slate-100 hover:text-slate-700 focus:outline-none focus:ring-2 focus:ring-primary-500"
                    aria-label="Ver notificaciones"
                >
                    <span class="w-5 h-5 block">@include('layouts.partials.icons', ['icon' => 'bell'])</span>
                    <span class="absolute top-1.5 right-1.5 w-2 h-2 rounded-full bg-red-500 ring-2 ring-white"></span>
                </button>

                <div
                    x-show="open" x-cloak
                    x-transition
                    class="absolute right-0 mt-2 w-80 bg-white rounded-xl shadow-lg border border-slate-100 overflow-hidden"
                >
                    <div class="px-4 py-3 border-b border-slate-100 font-semibold text-sm text-slate-700">
                        Notificaciones
                    </div>
                    <ul class="max-h-72 overflow-y-auto divide-y divide-slate-100">
                        @forelse (($notifications ?? []) as $notification)
                            <li class="px-4 py-3 text-sm hover:bg-slate-50">
                                <p class="text-slate-700">{{ $notification['message'] }}</p>
                                <p class="text-xs text-slate-400 mt-1">{{ $notification['time'] }}</p>
                            </li>
                        @empty
                            <li class="px-4 py-6 text-sm text-slate-400 text-center">Sin notificaciones nuevas</li>
                        @endforelse
                    </ul>
                </div>
            </div>

            
            {{-- Menú de usuario --}}
            <div x-data="{ open: false }" class="relative">

                @php
                    $usuarioActual = auth()->user();

                    $nombreCompleto = trim(
                        $usuarioActual->nombre . ' ' . $usuarioActual->apellido
                    );

                    $rolActual = $usuarioActual->roles->first()?->name;

                    $nombreRol = match ($rolActual) {
                        'administrador' => 'Administrador',
                        'veterinario' => 'Veterinario',
                        'usuario' => 'Usuario',
                        default => 'Sin rol asignado',
                    };
                @endphp

                {{-- Botón principal --}}
                <button
                    @click="open = !open"
                    @click.outside="open = false"
                    type="button"
                    class="flex items-center gap-2 pl-1 pr-2 py-1 rounded-lg
                        hover:bg-slate-100 focus:outline-none
                        focus:ring-2 focus:ring-primary-500"
                    aria-haspopup="true"
                    :aria-expanded="open.toString()">

                    {{-- Foto del usuario --}}
                    <img
                        class="w-9 h-9 rounded-full object-cover ring-1 ring-slate-200"
                        src="{{ $usuarioActual->avatar_url ?? 'https://ui-avatars.com/api/?name=' . urlencode($nombreCompleto) . '&background=EAF4F5&color=306174' }}"
                        alt="Foto de {{ $nombreCompleto }}">

                    {{-- Nombre y rol --}}
                    <div class="hidden sm:flex flex-col items-start min-w-0">

                        <span class="text-sm font-semibold text-slate-700 truncate max-w-40">
                            {{ $nombreCompleto }}
                        </span>

                        <span class="text-xs text-slate-500">
                            {{ $nombreRol }}
                        </span>

                    </div>

                    {{-- Flecha desplegable --}}
                    <span class="w-4 h-4 text-slate-400 hidden sm:block">
                        @include('layouts.partials.icons', ['icon' => 'chevron-down'])
                    </span>

                </button>

                {{-- Menú desplegable --}}
                <div
                    x-show="open"
                    x-cloak
                    x-transition
                    class="absolute right-0 mt-2 w-56 bg-white rounded-xl
                        shadow-lg border border-slate-100 overflow-hidden py-1"
                >

                    {{-- Información del usuario 
                    <div class="px-4 py-3 border-b border-slate-100 bg-slate-50">

                        <p class="text-sm font-semibold text-slate-800 truncate">
                            {{ $nombreCompleto }}
                        </p>

                        <p class="text-xs text-slate-500 mt-1">
                            {{ $nombreRol }}
                        </p>

                    </div>--}}

                    {{-- Mi perfil --}}
                    <a
                        href="{{ route('perfil.index') }}"
                        class="flex items-center gap-2 px-4 py-2.5
                            text-sm text-slate-600 hover:bg-slate-50
                            hover:text-primary-700 transition"
                    >
                        @include('layouts.partials.icons', ['icon' => 'usuario'])

                        Mi perfil
                    </a>

                    {{-- Cerrar sesión --}}
                    <div class="border-t border-slate-100">

                        <form
                            method="POST"
                            action="{{ Route::has('logout') ? route('logout') : '#' }}"
                        >
                            @csrf

                            <button
                                type="submit"
                                class="w-full flex items-center gap-2 px-4 py-2.5
                                    text-sm text-red-600 hover:bg-red-50 transition"
                            >
                                <svg
                                    class="w-4 h-4"
                                    fill="none"
                                    viewBox="0 0 24 24"
                                    stroke="currentColor"
                                >
                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        stroke-width="2"
                                        d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"
                                    />
                                </svg>

                                Cerrar sesión
                            </button>

                        </form>

                    </div>

                </div>

            </div>

        </div>
    </div>
</header>
