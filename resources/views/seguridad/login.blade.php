@extends('seguridad.layout-auth')

@section('title', 'Iniciar sesión')

@section('content')

    <main class="min-h-screen flex items-center justify-center p-4">
        <div class="w-full max-w-md">
            <div class="flex flex-col items-center mb-2">
                <img src="{{ asset('img/logo.png') }}"
                alt="Logo GEMAS"
                class="w-28 h-28 object-contain mb-2">
            </div>

            <div class="bg-white rounded-xl border border-slate-200 shadow-sm p-6">

                <a href="{{ route('catalogo.index') }}"
                class="inline-flex items-center gap-2 text-sm text-primary-600 hover:text-primary-800 font-medium mb-4">

                    <svg xmlns="http://www.w3.org/2000/svg"
                        class="w-4 h-4"
                        fill="none"
                        viewBox="0 0 24 24"
                        stroke="currentColor"
                        stroke-width="2">
                        <path stroke-linecap="round"
                            stroke-linejoin="round"
                            d="M15 19l-7-7 7-7" />
                    </svg>

                    Volver al catálogo
                </a>

                <h2 class="text-lg font-semibold">Iniciar sesión</h2>
                <p class="text-sm text-slate-500 mb-5">Ingresa tus credenciales para continuar</p>

                <form action="{{ route('login.store') }}" method="POST" class="space-y-4">
                    @csrf

                    <div>
                        <label for="email" class="block text-sm font-medium text-slate-700 mb-1">Correo electrónico</label>
                        <input type="email" name="email" id="email" value="{{ old('email') }}" required autofocus autocomplete="email"
                            class="w-full rounded-md border-slate-300 shadow-sm focus:border-primary-500 focus:ring-primary-500 border px-3 py-2 @error('email') border-red-500 @enderror">
                        @error('email')
                            <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="password" class="block text-sm font-medium text-slate-700 mb-1">
                            Contraseña
                        </label>

                        <div class="relative">
                            <input
                                type="password"
                                name="password"
                                id="password"
                                required
                                autocomplete="current-password"
                                class="w-full rounded-md border-slate-300 shadow-sm focus:border-primary-500 focus:ring-primary-500 border px-3 py-2 pr-12"
                            >

                            <button
                                type="button"
                                id="mostrarPassword"
                                class="absolute inset-y-0 right-0 flex items-center px-3 text-slate-500 hover:text-primary-600"
                                aria-label="Mostrar contraseña"
                                title="Mostrar contraseña"
                            >
                                <svg id="iconoMostrar" xmlns="http://www.w3.org/2000/svg"
                                    class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                </svg>
                            </button>
                        </div>

                        @error('password')
                            <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="text-right">
                        <a href="{{ route('password.request') }}"
                        class="text-sm text-primary-600 hover:text-primary-800 font-medium">
                            ¿Olvidaste tu contraseña?
                        </a>
                    </div>

                    <label class="flex items-center gap-2 text-sm text-slate-600">
                        <input type="checkbox" name="remember" value="1" class="rounded border-slate-300 h-4 w-4 text-primary-600 focus:ring-primary-500">
                        Recordarme
                    </label>

                    <button type="submit" class="w-full rounded-md bg-primary-600 hover:bg-primary-700 text-white font-medium py-2">
                        Ingresar
                    </button>

                    <div class="mt-5 text-center border-t border-slate-200 pt-4">
                        <p class="text-sm text-slate-600">
                            ¿Aún no tienes una cuenta?
                            <a href="{{ route('registro') }}"
                            class="font-medium text-primary-600 hover:text-primary-800">
                                Regístrate aquí
                            </a>
                        </p>
                    </div>

                </form>
            </div>
        </div>
    </main>

@endsection

@push('scripts')
    <script>
        const campoPassword = document.getElementById('password');
        const botonMostrar = document.getElementById('mostrarPassword');

        botonMostrar.addEventListener('click', function () {
            const mostrar = campoPassword.type === 'password';

            campoPassword.type = mostrar ? 'text' : 'password';

            this.setAttribute(
                'aria-label',
                mostrar ? 'Ocultar contraseña' : 'Mostrar contraseña'
            );

            this.setAttribute(
                'title',
                mostrar ? 'Ocultar contraseña' : 'Mostrar contraseña'
            );

            this.innerHTML = mostrar
                ? `<svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5"
                    fill="none" viewBox="0 0 24 24" stroke="currentColor"
                    stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M3 3l18 18M10.584 10.587a2 2 0 002.829 2.829" />
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M9.88 5.09A10.94 10.94 0 0112 4.9c4.478 0 8.268 2.943 9.542 7a10.97 10.97 0 01-4.043 5.18M6.61 6.61A10.97 10.97 0 002.458 12c1.274 4.057 5.064 7 9.542 7 1.05 0 2.06-.16 3-.46" />
                </svg>`
                : `<svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5"
                    fill="none" viewBox="0 0 24 24" stroke="currentColor"
                    stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                </svg>`;
        });
    </script>
@endpush