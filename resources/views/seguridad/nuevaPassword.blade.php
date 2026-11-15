@extends('seguridad.layout-auth')

@section('title', 'Crear nueva contraseña')

@section('content')

    {{-- Contenedor principal --}}
    <main class="min-h-screen flex items-center justify-center bg-slate-50 px-4 py-10">
        <div class="w-full max-w-md">

            <div class="flex flex-col items-center mb-2">
                <img src="{{ asset('img/logo.png') }}"
                alt="Logo GEMAS"
                class="w-28 h-28 object-contain mb-2">
            </div>

            {{-- Tarjeta --}}
            <div class="bg-white rounded-xl border border-slate-200 shadow-sm p-6">

                {{-- Encabezado --}}
                <h2 class="text-lg font-semibold text-slate-900">
                    Crear nueva contraseña
                </h2>

                <p class="text-sm text-slate-500 mb-5">
                    Tu identidad ha sido verificada. Ahora puedes establecer una nueva contraseña.
                </p>

                {{-- Formulario --}}
                <form action="{{ route('password.nueva.actualizar') }}" method="POST" class="space-y-4">
                    @csrf

                    {{-- Nueva contraseña --}}
                    <div>
                        <label for="password" class="block text-sm font-medium text-slate-700 mb-1">
                            Nueva contraseña
                        </label>

                        <div class="relative">
                            <input
                                type="password"
                                name="password"
                                id="password"
                                required
                                minlength="8"
                                autocomplete="new-password"
                                class="w-full rounded-md border border-slate-300 shadow-sm focus:border-primary-500 focus:ring-primary-500 px-3 py-2 pr-11 @error('password') border-red-500 @enderror"
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
                            <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
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
                                minlength="8"
                                autocomplete="new-password"
                                class="w-full rounded-md border border-slate-300 shadow-sm focus:border-primary-500 focus:ring-primary-500 px-3 py-2 pr-11"
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
                    <div class="rounded-lg border border-primary-100 bg-primary-50 p-3">
                        <p class="text-sm font-semibold text-slate-700 mb-2">
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

                    {{-- Boton --}}
                    <button
                        type="submit"
                        class="w-full inline-flex items-center justify-center rounded-lg bg-primary-600 hover:bg-primary-700 text-white text-sm font-semibold px-5 py-2.5 transition"
                    >
                        Guardar nueva contraseña
                    </button>

                </form>
            </div>
        </div>
    </main>

@endsection

{{-- Script para mostrar u ocultar contraseñas --}}
@push('scripts')
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
                    validar: valor => /[@#$!*/%]/.test(valor)
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
            document.querySelectorAll('[data-password-toggle]').forEach(function (boton) {

                boton.addEventListener('click', function () {

                    const inputId = boton.dataset.passwordToggle;
                    const input = document.getElementById(inputId);
                    const linea = boton.querySelector('.linea-ojo');

                    if (!input) return;

                    const mostrar = input.type === 'password';

                    input.type = mostrar ? 'text' : 'password';

                    if (linea) {
                        linea.style.display = mostrar ? 'block' : 'none';
                    }

                    boton.setAttribute(
                        'aria-label',
                        mostrar ? 'Ocultar contraseña' : 'Mostrar contraseña'
                    );
                });

            });


        });
    </script>
@endpush
