@extends('layouts.app')

@section('title')
    Nuevo usuario - Gemas
@endsection

@section('content')
    
    <div class="w-full max-w-3xl mx-auto space-y-6">

        {{-- Encabezado --}}
        <div>
            <h2 class="text-2xl font-bold text-slate-800">
                Nuevo usuario
            </h2>

            <p class="mt-1 text-sm text-slate-500">
                Registra la información personal y de acceso del usuario.
            </p>
        </div>

        {{-- Errores de validación --}}
        @if ($errors->any())
            <div class="rounded-xl border border-red-200 bg-red-50 p-4 text-red-700">
                <p class="font-semibold">No se pudo registrar el usuario</p>

                <ul class="mt-2 list-disc space-y-1 pl-5 text-sm">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        {{-- Tarjeta del formulario --}}
        <div class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">

            {{-- Encabezado de la tarjeta --}}
            <div class="border-b border-slate-100 px-6 py-5">
                <div class="flex items-center gap-3">

                    <div class="flex h-11 w-11 items-center justify-center rounded-xl bg-[#EAF4F5] text-[#40899A]">
                        @include('layouts.partials.icons', ['icon' => 'usuario'])
                    </div>

                    <div>
                        <h3 class="font-semibold text-slate-800">
                            Información personal
                        </h3>

                        <p class="text-sm text-slate-500">
                            Completa los campos para registrar al usuario.
                        </p>
                    </div>

                </div>
            </div>

            <form action="{{ route('usuario.store') }}" method="POST">
                @csrf

                <div class="space-y-6 p-6">

                    {{-- Información personal --}}
                    <div>
                        <h4 class="mb-4 text-sm font-semibold text-slate-700">
                            Datos personales
                        </h4>

                        <div class="grid grid-cols-1 gap-5 sm:grid-cols-2">

                            {{-- Nombre --}}
                            <div>
                                <label for="nombre" class="mb-2 block text-sm font-medium text-slate-700">
                                    Nombre <span class="text-red-500">*</span>
                                </label>

                                <input
                                    type="text"
                                    name="nombre"
                                    id="nombre"
                                    value="{{ old('nombre') }}"
                                    placeholder="Nombre del usuario"
                                    required
                                    class="w-full rounded-lg border border-slate-300 px-3 py-2.5 text-sm text-slate-700 outline-none transition focus:border-primary-600 focus:ring-2 focus:ring-primary-100"
                                >
                            </div>

                            {{-- Apellido --}}
                            <div>
                                <label for="apellido" class="mb-2 block text-sm font-medium text-slate-700">
                                    Apellido <span class="text-red-500">*</span>
                                </label>

                                <input
                                    type="text"
                                    name="apellido"
                                    id="apellido"
                                    value="{{ old('apellido') }}"
                                    placeholder="Apellido del usuario"
                                    required
                                    class="w-full rounded-lg border border-slate-300 px-3 py-2.5 text-sm text-slate-700 outline-none transition focus:border-primary-600 focus:ring-2 focus:ring-primary-100"
                                >
                            </div>

                            {{-- Documento --}}
                            <div>
                                <label for="documentoIdentidad" class="mb-2 block text-sm font-medium text-slate-700">
                                    Documento de identidad <span class="text-red-500">*</span>
                                </label>

                                <input
                                    type="text"
                                    name="documentoIdentidad"
                                    id="documentoIdentidad"
                                    value="{{ old('documentoIdentidad') }}"
                                    placeholder="Número de documento"
                                    required
                                    class="w-full rounded-lg border border-slate-300 px-3 py-2.5 text-sm text-slate-700 outline-none transition focus:border-primary-600 focus:ring-2 focus:ring-primary-100"
                                >
                            </div>

                            {{-- Teléfono --}}
                            <div>
                                <label for="telefono" class="mb-2 block text-sm font-medium text-slate-700">
                                    Teléfono <span class="text-red-500">*</span>
                                </label>

                                <input
                                    type="text"
                                    name="telefono"
                                    id="telefono"
                                    value="{{ old('telefono') }}"
                                    placeholder="Número de contacto"
                                    required
                                    class="w-full rounded-lg border border-slate-300 px-3 py-2.5 text-sm text-slate-700 outline-none transition focus:border-primary-600 focus:ring-2 focus:ring-primary-100"
                                >
                            </div>

                            {{-- Correo --}}
                            <div>
                                <label for="email" class="mb-2 block text-sm font-medium text-slate-700">
                                    Correo electrónico <span class="text-red-500">*</span>
                                </label>

                                <input
                                    type="email"
                                    name="email"
                                    id="email"
                                    value="{{ old('email') }}"
                                    placeholder="correo@ejemplo.com"
                                    required
                                    class="w-full rounded-lg border border-slate-300 px-3 py-2.5 text-sm text-slate-700 outline-none transition focus:border-primary-600 focus:ring-2 focus:ring-primary-100"
                                >
                            </div>

                            {{-- Dirección --}}
                            <div>
                                <label for="direccion" class="mb-2 block text-sm font-medium text-slate-700">
                                    Dirección
                                </label>

                                <input
                                    type="text"
                                    name="direccion"
                                    id="direccion"
                                    value="{{ old('direccion') }}"
                                    placeholder="Dirección de residencia"
                                    class="w-full rounded-lg border border-slate-300 px-3 py-2.5 text-sm text-slate-700 outline-none transition focus:border-primary-600 focus:ring-2 focus:ring-primary-100"
                                >
                            </div>

                        </div>
                    </div>

                    {{-- Información de acceso --}}
                    <div>
                        <h4 class="mb-4 text-sm font-semibold text-slate-700">
                            Información de acceso
                        </h4>

                        <div class="grid grid-cols-1 gap-5 sm:grid-cols-2">

                            {{-- Contraseña --}}
                            <div>
                                <label for="password" class="mb-2 block text-sm font-medium text-slate-700">
                                    Contraseña <span class="text-red-500">*</span>
                                </label>

                                <div class="relative">
                                    <input
                                        type="password"
                                        name="password"
                                        id="password"
                                        placeholder="Ingresa una contraseña"
                                        required
                                        autocomplete="new-password"
                                        class="w-full rounded-lg border border-slate-300 px-3 py-2.5 pr-12 text-sm text-slate-700 outline-none transition focus:border-primary-600 focus:ring-2 focus:ring-primary-100"
                                    >

                                    <button
                                        type="button"
                                        data-password-toggle="password"
                                        class="absolute inset-y-0 right-0 flex items-center px-3 text-slate-500 hover:text-primary-600"
                                        aria-label="Mostrar contraseña">
                                        <svg xmlns="http://www.w3.org/2000/svg"
                                            class="h-5 w-5"
                                            fill="none"
                                            viewBox="0 0 24 24"
                                            stroke="currentColor"
                                            stroke-width="2">

                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M2.458 12C3.732 7.943 7.523 5 12 5c4.477 0 8.268 2.943 9.542 7-1.274 4.057-5.065 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />

                                            <circle cx="12" cy="12" r="3" />

                                            <path class="linea-ojo" stroke-linecap="round"
                                                d="M3 3l18 18" style="display: none;" />
                                        </svg>
                                    </button>
                                </div>
                            </div>

                            {{-- Confirmar contraseña --}}
                            <div>
                                <label for="password_confirmation" class="mb-2 block text-sm font-medium text-slate-700">
                                    Confirmar contraseña <span class="text-red-500">*</span>
                                </label>

                                <div class="relative">
                                    <input
                                        type="password"
                                        name="password_confirmation"
                                        id="password_confirmation"
                                        placeholder="Repite la contraseña"
                                        required
                                        autocomplete="new-password"
                                        class="w-full rounded-lg border border-slate-300 px-3 py-2.5 pr-12 text-sm text-slate-700 outline-none transition focus:border-primary-600 focus:ring-2 focus:ring-primary-100"
                                    >

                                    <button
                                        type="button"
                                        data-password-toggle="password_confirmation"
                                        class="absolute inset-y-0 right-0 flex items-center px-3 text-slate-500 hover:text-primary-600"
                                        aria-label="Mostrar contraseña">
                                        <svg xmlns="http://www.w3.org/2000/svg"
                                            class="h-5 w-5"
                                            fill="none"
                                            viewBox="0 0 24 24"
                                            stroke="currentColor"
                                            stroke-width="2">

                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M2.458 12C3.732 7.943 7.523 5 12 5c4.477 0 8.268 2.943 9.542 7-1.274 4.057-5.065 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />

                                            <circle cx="12" cy="12" r="3" />

                                            <path class="linea-ojo" stroke-linecap="round"
                                                d="M3 3l18 18" style="display: none;" />
                                        </svg>
                                    </button>
                                </div>

                                <p id="password-error" class="hidden mt-2 text-xs text-red-600">
                                    Las contraseñas no coinciden.
                                </p>
                            </div>

                            {{-- Requerimientos de la contraseña --}}
                            <div class="sm:col-span-2 rounded-lg border border-primary-100 bg-primary-50 p-3">

                                <p class="mb-2 text-sm font-semibold text-slate-700">
                                    La contraseña debe cumplir con:
                                </p>

                                <ul class="space-y-1.5 text-xs text-slate-600">

                                    <li id="requisito-longitud" class="flex items-center gap-2">
                                        <span class="indicador">○</span>
                                        Mínimo 8 caracteres.
                                    </li>

                                    <li id="requisito-mayuscula" class="flex items-center gap-2">
                                        <span class="indicador">○</span>
                                        Al menos una letra mayúscula y una minúscula.
                                    </li>

                                    <li id="requisito-numero" class="flex items-center gap-2">
                                        <span class="indicador">○</span>
                                        Al menos un número.
                                    </li>

                                    <li id="requisito-especial" class="flex items-center gap-2">
                                        <span class="indicador">○</span>
                                        Al menos un carácter especial: *, /, @, #, $, ! o %.
                                    </li>

                                </ul>
                            </div>

                        </div>
                    </div>

                </div>

                {{-- Botones --}}
                <div class="flex flex-col-reverse gap-3 border-t border-slate-100 bg-slate-50/70 px-6 py-4 sm:flex-row sm:justify-end">

                    <a
                        href="{{ route('usuario.index') }}"
                        class="inline-flex items-center justify-center rounded-lg border border-slate-300 bg-white px-5 py-2.5 text-sm font-semibold text-slate-700 transition hover:bg-slate-100"
                    >
                        Cancelar
                    </a>

                    <button
                        type="submit"
                        class="inline-flex items-center justify-center rounded-lg bg-primary-600 px-5 py-2.5 text-sm font-semibold text-white transition hover:bg-primary-700 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:ring-offset-2"
                    >
                        Registrar usuario
                    </button>

                </div>

            </form>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const password = document.getElementById('password');
            const passwordConfirmation = document.getElementById('password_confirmation');
            const passwordError = document.getElementById('password-error');

            // Validar requisitos de contraseña
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
                    validar: valor => /[@#$!*/]/.test(valor)
                }
            };

            function validarRequisitos() {

                const valor = password.value;

                Object.values(requisitos).forEach(requisito => {

                    const cumplido = requisito.validar(valor);
                    const indicador = requisito.elemento.querySelector('.indicador');

                    if (cumplido) {
                        requisito.elemento.classList.remove('text-slate-500');
                        requisito.elemento.classList.add('text-green-600');

                        indicador.textContent = '✓';
                    } else {
                        requisito.elemento.classList.remove('text-green-600');
                        requisito.elemento.classList.add('text-slate-500');

                        indicador.textContent = '○';
                    }

                });

            }

            // Validar coincidencia de contraseñas
            function validarCoincidencia() {

                if (passwordConfirmation.value === '') {
                    passwordError.classList.add('hidden');
                    passwordConfirmation.classList.remove('border-red-400', 'border-green-500');
                    return;
                }

                if (password.value !== passwordConfirmation.value) {

                    passwordError.classList.remove('hidden');

                    passwordConfirmation.classList.add('border-red-400');
                    passwordConfirmation.classList.remove('border-green-500');

                } else {

                    passwordError.classList.add('hidden');

                    passwordConfirmation.classList.remove('border-red-400');
                    passwordConfirmation.classList.add('border-green-500');

                }

            }

            password.addEventListener('input', function () {
                validarRequisitos();
                validarCoincidencia();
            });

            passwordConfirmation.addEventListener('input', validarCoincidencia);

            // Mostrar u ocultar contraseñas
            document.querySelectorAll('[data-password-toggle]').forEach(boton => {

                boton.addEventListener('click', function () {

                    const inputId = boton.dataset.passwordToggle;
                    const input = document.getElementById(inputId);

                    if (!input) return;

                    const mostrar = input.type === 'password';

                    input.type = mostrar ? 'text' : 'password';

                    boton.innerHTML = mostrar
                        ? `
                            {{-- Ojo cerrado --}}
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
                            {{-- Ojo abierto --}}
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

@endsection