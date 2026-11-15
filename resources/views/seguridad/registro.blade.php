@extends('seguridad.layout-auth')

@section('title', 'Crear cuenta')

@section('content')

    {{-- Contenedor principal --}}
    <main class="min-h-screen flex flex-col items-center justify-center bg-slate-50 px-4 py-4">

        <div class="w-full max-w-2xl">

            {{-- Logo --}}
            <div class="flex flex-col items-center mb-2">
                <img
                    src="{{ asset('img/logo.png') }}"
                    alt="Logo GEMAS"
                    class="w-28 h-28 object-contain"
                >
            </div>

            {{-- Tarjeta --}}
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

                {{-- Encabezado --}}
                <h1 class="text-2xl font-semibold text-slate-900">
                    Crear cuenta
                </h1>

                <p class="text-sm text-slate-500 mb-6">
                    Regístrate para acceder a los servicios de GEMAS.
                </p>

                {{-- Formulario --}}
                <form action="{{ route('registro.store') }}" method="POST"
                      class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    @csrf

                    @php
                        $campos = [
                            'nombre' => 'Nombre',
                            'apellido' => 'Apellido',
                            'documentoIdentidad' => 'Documento de identidad',
                            'telefono' => 'Teléfono',
                            'direccion' => 'Dirección',
                            'email' => 'Correo electrónico',
                        ];
                    @endphp

                    {{-- Datos personales --}}
                    @foreach ($campos as $campo => $etiqueta)
                        <div>
                            <label for="{{ $campo }}" class="block text-sm font-medium text-slate-700 mb-1">
                                {{ $etiqueta }}
                            </label>

                            <input
                                type="{{ $campo === 'email' ? 'email' : 'text' }}"
                                name="{{ $campo }}"
                                id="{{ $campo }}"
                                value="{{ old($campo) }}"
                                @if ($campo !== 'direccion') required @endif
                                autocomplete="{{ $campo === 'email' ? 'email' : 'off' }}"
                                class="w-full rounded-md border border-slate-300 px-3 py-2 shadow-sm focus:border-primary-500 focus:ring-primary-500 @error($campo) border-red-500 @enderror"
                            >

                            @error($campo)
                                <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    @endforeach

                    {{-- Contraseña --}}
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
                                autocomplete="new-password"
                                class="w-full rounded-md border border-slate-300 px-3 py-2 pr-11 shadow-sm focus:border-primary-500 focus:ring-primary-500 @error('password') border-red-500 @enderror"
                            >

                            <button
                                type="button"
                                data-password-toggle="password"
                                class="absolute inset-y-0 right-0 flex items-center px-3 text-slate-500 hover:text-primary-600"
                                aria-label="Mostrar contraseña"
                            >
                                <svg xmlns="http://www.w3.org/2000/svg"
                                    class="h-5 w-5"
                                    fill="none"
                                    viewBox="0 0 24 24"
                                    stroke="currentColor"
                                    stroke-width="2">

                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        d="M2.458 12C3.732 7.943 7.523 5 12 5c4.477 0 8.268 2.943 9.542 7-1.274 4.057-5.065 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"
                                    />

                                    <circle cx="12" cy="12" r="3" />

                                    <path
                                        class="linea-ojo"
                                        stroke-linecap="round"
                                        d="M3 3l18 18"
                                        style="display: none;"
                                    />
                                </svg>
                            </button>
                        </div>

                        @error('password')
                            <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Confirmar contraseña --}}
                    <div>
                        <label for="password_confirmation" class="block text-sm font-medium text-slate-700 mb-1">
                            Confirmar contraseña
                        </label>

                        <div class="relative">
                            <input
                                type="password"
                                name="password_confirmation"
                                id="password_confirmation"
                                required
                                autocomplete="new-password"
                                class="w-full rounded-md border border-slate-300 px-3 py-2 pr-11 shadow-sm focus:border-primary-500 focus:ring-primary-500"
                            >

                            <button
                                type="button"
                                data-password-toggle="password_confirmation"
                                class="absolute inset-y-0 right-0 flex items-center px-3 text-slate-500 hover:text-primary-600"
                                aria-label="Mostrar contraseña"
                            >
                                <svg xmlns="http://www.w3.org/2000/svg"
                                    class="h-5 w-5"
                                    fill="none"
                                    viewBox="0 0 24 24"
                                    stroke="currentColor"
                                    stroke-width="2">

                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        d="M2.458 12C3.732 7.943 7.523 5 12 5c4.477 0 8.268 2.943 9.542 7-1.274 4.057-5.065 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"
                                    />

                                    <circle cx="12" cy="12" r="3" />

                                    <path
                                        class="linea-ojo"
                                        stroke-linecap="round"
                                        d="M3 3l18 18"
                                        style="display: none;"
                                    />
                                </svg>
                            </button>
                        </div>

                        <p id="password-error" class="hidden text-xs text-red-600 mt-1">
                            Las contraseñas no coinciden.
                        </p>
                    </div>

                    {{-- Requerimientos de la contraseña --}}
                    <div class="md:col-span-2 w-full rounded-lg border border-primary-100 bg-primary-50 p-3">

                        <p class="text-sm font-semibold text-slate-700 mb-2">
                            La contraseña debe cumplir con:
                        </p>

                        <ul class="flex flex-col gap-2 text-xs text-slate-600">

                            <li id="requisito-longitud" class="flex items-center gap-2">
                                <span class="indicador shrink-0">○</span>
                                Mínimo 8 caracteres.
                            </li>

                            <li id="requisito-mayuscula" class="flex items-center gap-2">
                                <span class="indicador shrink-0">○</span>
                                Al menos una letra mayúscula y una minúscula.
                            </li>

                            <li id="requisito-numero" class="flex items-center gap-2">
                                <span class="indicador shrink-0">○</span>
                                Al menos un número.
                            </li>

                            <li id="requisito-especial" class="flex items-center gap-2">
                                <span class="indicador shrink-0">○</span>
                                Al menos un carácter especial: *, /, @, #, $, ! o %.
                            </li>

                        </ul>
                    </div>

                    {{-- Botones y acceso --}}
                    <div class="md:col-span-2 flex flex-col gap-4 mt-3">

                        <button
                            type="submit"
                            class="w-full inline-flex items-center justify-center rounded-lg bg-primary-600 hover:bg-primary-700 text-white text-sm font-semibold px-5 py-2.5 transition"
                        >
                            Crear cuenta
                        </button>

                        {{-- Iniciar sesion --}}
                        <div class="text-center border-t border-slate-200 pt-4">
                            <p class="text-sm text-slate-600">
                                ¿Ya tienes cuenta?
                                <a
                                    href="{{ route('login') }}"
                                    class="font-medium text-primary-600 hover:text-primary-800 transition"
                                >
                                    Inicia sesión
                                </a>
                            </p>
                        </div>

                    </div>
                </form>
            </div>
        </div>
    </main>

@endsection

{{-- Script para mostrar u ocultar contraseñas --}}
@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function () {

            const formulario = document.querySelector('form');
            const password = document.getElementById('password');
            const passwordConfirmation = document.getElementById('password_confirmation');
            const passwordError = document.getElementById('password-error');

            // Requisitos de la contraseña
            const requisitos = {
                longitud: {
                    elemento: document.getElementById('requisito-longitud'),
                    validar: valor => valor.length >= 8
                },
                mayuscula: {
                    elemento: document.getElementById('requisito-mayuscula'),
                    validar: valor => /[A-Z]/.test(valor) && /[a-z]/.test(valor)
                },
                numero: {
                    elemento: document.getElementById('requisito-numero'),
                    validar: valor => /[0-9]/.test(valor)
                },
                especial: {
                    elemento: document.getElementById('requisito-especial'),
                    validar: valor => /[^A-Za-z0-9]/.test(valor)
                }
            };

            // Comprobar los requisitos en tiempo real
            function validarRequisitos() {

                const valor = password.value;

                Object.values(requisitos).forEach(requisito => {

                    const cumplido = requisito.validar(valor);
                    const indicador = requisito.elemento.querySelector('.indicador');

                    if (cumplido) {
                        requisito.elemento.classList.remove('text-slate-600', 'text-slate-500');
                        requisito.elemento.classList.add('text-green-600');

                        indicador.textContent = '✓';

                    } else {
                        requisito.elemento.classList.remove('text-green-600');
                        requisito.elemento.classList.add('text-slate-600');

                        indicador.textContent = '○';
                    }

                });

            }

            // Comprobar que ambas contraseñas coincidan
            function validarCoincidencia() {

                if (passwordConfirmation.value === '') {

                    passwordError.classList.add('hidden');

                    passwordConfirmation.classList.remove(
                        'border-red-400',
                        'border-green-500'
                    );

                    return false;
                }

                const coinciden = password.value === passwordConfirmation.value;

                if (!coinciden) {

                    passwordError.classList.remove('hidden');

                    passwordConfirmation.classList.add('border-red-400');
                    passwordConfirmation.classList.remove('border-green-500');

                } else {

                    passwordError.classList.add('hidden');

                    passwordConfirmation.classList.remove('border-red-400');
                    passwordConfirmation.classList.add('border-green-500');

                }

                return coinciden;
            }

            // Validar contraseña al escribir
            password.addEventListener('input', function () {
                validarRequisitos();
                validarCoincidencia();
            });

            // Validar confirmación al escribir
            passwordConfirmation.addEventListener('input', validarCoincidencia);

            // Impedir el envío si la contraseña no cumple
            formulario.addEventListener('submit', function (event) {

                validarRequisitos();

                const todosCumplidos = Object.values(requisitos).every(
                    requisito => requisito.validar(password.value)
                );

                const coinciden = validarCoincidencia();

                if (!todosCumplidos || !coinciden) {
                    event.preventDefault();
                }

            });

            // Mostrar u ocultar ambas contraseñas
            document.querySelectorAll('[data-password-toggle]').forEach(boton => {

                boton.addEventListener('click', function () {

                    const inputId = boton.dataset.passwordToggle;
                    const input = document.getElementById(inputId);

                    if (!input) return;

                    const mostrar = input.type === 'password';

                    input.type = mostrar ? 'text' : 'password';

                    boton.innerHTML = mostrar
                        ? `
                            <svg xmlns="http://www.w3.org/2000/svg"
                                class="h-5 w-5"
                                fill="none"
                                viewBox="0 0 24 24"
                                stroke="currentColor"
                                stroke-width="2">
                                <path stroke-linecap="round"
                                    stroke-linejoin="round"
                                    d="M3 3l18 18M10.58 10.58a2 2 0 002.84 2.84M9.88 5.09A10.94 10.94 0 0112 4.5c6.25 0 9.75 7.5 9.75 7.5a13.8 13.8 0 01-3.1 3.9M6.18 6.18C3.7 7.8 2.25 12 2.25 12s3.5 7.5 9.75 7.5c1.1 0 2.1-.2 3-.5"/>
                            </svg>
                        `
                        : `
                            <svg xmlns="http://www.w3.org/2000/svg"
                                class="h-5 w-5"
                                fill="none"
                                viewBox="0 0 24 24"
                                stroke="currentColor"
                                stroke-width="2">
                                <path stroke-linecap="round"
                                    stroke-linejoin="round"
                                    d="M2.25 12s3.5-7 9.75-7 9.75 7 9.75 7-3.5 7-9.75 7-9.75-7-9.75-7z"/>
                                <circle cx="12" cy="12" r="3"/>
                            </svg>
                        `;

                    boton.setAttribute(
                        'aria-label',
                        mostrar ? 'Ocultar contraseña' : 'Mostrar contraseña'
                    );

                });

            });

        });
    </script>
@endpush

