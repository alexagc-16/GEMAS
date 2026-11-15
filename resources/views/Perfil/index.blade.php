@extends('layouts.app')

@section('title')
    Mi perfil - Gemas
@endsection

@section('content')

    <div class="w-full max-w-5xl mx-auto space-y-6">

        {{-- Encabezado --}}
        <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">

            <div>
                <h1 class="text-xl sm:text-2xl font-bold text-slate-800">
                    Mi perfil
                </h1>

                <p class="mt-1 text-sm text-slate-500">
                    Consulta y administra la información de tu cuenta.
                </p>
            </div>

            <a href="{{ route('perfil.edit') }}"
                class="inline-flex items-center justify-center gap-2 rounded-lg bg-[#40899A] px-5 py-2.5 text-sm font-semibold text-white shadow-sm transition hover:bg-[#347483]">

                <svg class="h-4 w-4" fill="none" stroke="currentColor"
                    viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        stroke-width="2"
                        d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5M18.5 2.5a2.12 2.12 0 013 3L12 15l-4 1 1-4 9.5-9.5z" />
                </svg>

                Editar perfil
            </a>

        </div>

        {{-- Mensaje de éxito --}}
        @if (session('success'))
            <div class="flex items-start gap-3 rounded-lg border border-green-200 bg-green-50 p-4 text-sm text-green-700">

                <svg class="mt-0.5 h-5 w-5 shrink-0" fill="none"
                    stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        stroke-width="2" d="M5 13l4 4L19 7" />
                </svg>

                <p>{{ session('success') }}</p>

            </div>
        @endif

        {{-- Información de la cuenta --}}
        <div class="overflow-hidden rounded-xl border border-slate-200 bg-white shadow-sm">

            {{-- Encabezado de la tarjeta --}}
            <div class="border-b border-slate-200 px-5 py-4 sm:px-6">

                <div class="flex items-center gap-3">

                    <div class="flex h-11 w-11 items-center justify-center rounded-xl bg-[#EAF4F5] text-[#40899A]">
                        @include('layouts.partials.icons', ['icon' => 'usuario'])
                    </div>

                    <div>
                        <h2 class="text-base font-semibold text-slate-800">
                            Información personal
                        </h2>

                        <p class="mt-0.5 text-xs text-slate-500">
                            Datos registrados en tu cuenta.
                        </p>
                    </div>

                </div>

            </div>

            {{-- Datos personales --}}
            <div class="grid grid-cols-1 gap-6 p-5 sm:grid-cols-2 sm:p-6">

                <div>
                    <p class="mb-1 text-xs font-medium text-slate-500">
                        Nombre
                    </p>

                    <p class="text-sm font-semibold text-slate-700">
                        {{ $perfil['usuario']->nombre }}
                    </p>
                </div>

                <div>
                    <p class="mb-1 text-xs font-medium text-slate-500">
                        Apellido
                    </p>

                    <p class="text-sm font-semibold text-slate-700">
                        {{ $perfil['usuario']->apellido }}
                    </p>
                </div>

                <div>
                    <p class="mb-1 text-xs font-medium text-slate-500">
                        Documento de identidad
                    </p>

                    <p class="text-sm font-semibold text-slate-700">
                        {{ $perfil['usuario']->documentoIdentidad }}
                    </p>
                </div>

                <div>
                    <p class="mb-1 text-xs font-medium text-slate-500">
                        Teléfono
                    </p>

                    <p class="text-sm font-semibold text-slate-700">
                        {{ $perfil['usuario']->telefono }}
                    </p>
                </div>

                <div>
                    <p class="mb-1 text-xs font-medium text-slate-500">
                        Correo electrónico
                    </p>

                    <p class="break-all text-sm font-semibold text-slate-700">
                        {{ $perfil['usuario']->email }}
                    </p>
                </div>

                @if (!$perfil['veterinario'] && $perfil['usuario']->direccion !== null)
                    <div>
                        <p class="mb-1 text-xs font-medium text-slate-500">
                            Dirección
                        </p>

                        <p class="text-sm font-semibold text-slate-700">
                            {{ $perfil['usuario']->direccion }}
                        </p>
                    </div>
                @endif

            </div>

            {{-- Información profesional del veterinario --}}
            @if ($perfil['veterinario'])

                <div class="border-t border-slate-200 px-5 py-5 sm:px-6">

                    <div class="mb-4 flex items-center gap-3">

                        <div class="flex h-11 w-11 items-center justify-center rounded-xl bg-[#EAF4F5] text-[#40899A]">
                            @include('layouts.partials.icons', ['icon' => 'veterinario'])
                        </div>

                        <div>
                            <h2 class="text-base font-semibold text-slate-800">
                                Información profesional
                            </h2>

                            <p class="mt-0.5 text-xs text-slate-500">
                                Datos relacionados con tu actividad veterinaria.
                            </p>
                        </div>

                    </div>

                    <div>
                        <p class="mb-1 text-xs font-medium text-slate-500">
                            Especialidad
                        </p>

                        <p class="text-sm font-semibold text-slate-700">
                            {{ $perfil['veterinario']->especialidad }}
                        </p>
                    </div>

                </div>

            @endif

            {{-- Seguridad --}}
            <div class="flex flex-col gap-4 border-t border-slate-200 px-5 py-5 sm:flex-row sm:items-center sm:justify-between sm:px-6">

                <div class="flex items-start gap-3">

                    <div class="flex h-9 w-9 shrink-0 items-center justify-center rounded-lg bg-[#EAF4F5] text-[#40899A]">
                        <svg class="h-5 w-5" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                stroke-width="1.8"
                                d="M12 15v2m-6 4h12a2 2 0 002-2v-7a2 2 0 00-2-2H6a2 2 0 00-2 2v7a2 2 0 002 2zm2-9V7a4 4 0 118 0v3" />
                        </svg>
                    </div>

                    <div>
                        <h3 class="text-sm font-semibold text-slate-800">
                            Seguridad de la cuenta
                        </h3>

                        <p class="mt-1 text-xs text-slate-500">
                            Mantén actualizada la contraseña de tu cuenta.
                        </p>
                    </div>

                </div>

                <a href="{{ route('seguridad.password.edit') }}"
                    class="inline-flex items-center gap-2 text-sm font-semibold text-[#40899A] transition hover:text-[#347483]">

                    Cambiar contraseña

                    <svg class="h-4 w-4" fill="none" stroke="currentColor"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            stroke-width="2" d="M5 12h14m-6-6l6 6-6 6" />
                    </svg>

                </a>

            </div>

        </div>

        {{-- Desactivar cuenta: únicamente para usuarios --}}
        @if ($perfil['usuario']->rolesConInactivos->contains('name', 'usuario'))

            <div class="overflow-hidden rounded-xl border border-red-200 bg-white shadow-sm">

                <div class="flex flex-col gap-4 p-5 sm:flex-row sm:items-center sm:justify-between sm:p-6">

                    <div class="flex items-start gap-3">

                        <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-red-50 text-red-600">
                            <svg class="h-5 w-5" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    stroke-width="1.8"
                                    d="M12 9v4m0 4h.01M10.3 3.86L1.82 18a2 2 0 001.7 3h16.96a2 2 0 001.7-3L13.7 3.86a2 2 0 00-3.4 0z" />
                            </svg>
                        </div>

                        <div>
                            <h3 class="text-sm font-semibold text-red-700">
                                Eliminar mi cuenta
                            </h3>

                            <p class="mt-1 text-sm text-slate-600">
                                Al eliminar tu cuenta, tendrás 7 días para recuperarla. 
                            </p>
                            
                            <p class="mt-1 text-sm text-slate-600">
                                Pasado este tiempo, perderás el acceso de forma permanente.
                            </p>
                        </div>

                    </div>

                    {{-- Botón eliminar cuenta --}}
                    <button type="button"
                        onclick="document.getElementById('modalEliminarCuenta').classList.remove('hidden'); document.getElementById('modalEliminarCuenta').classList.add('flex')"
                        class="inline-flex items-center justify-center gap-2 text-sm font-normal text-red-600 transition hover:text-red-700 sm:mr-2">

                        <svg class="h-5 w-5" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                stroke-width="1.8"
                                d="M6 7h12m-10 0V5h8v2m-9 2 1 11h8l1-11M10 11v5m4-5v5" />
                        </svg>

                        Eliminar cuenta

                    </button>

                    {{-- Modal de confirmación --}}
                    <div id="modalEliminarCuenta"
                        class="fixed inset-0 z-50 hidden items-center justify-center bg-slate-900/50 p-4">

                        <div class="w-full max-w-md rounded-2xl bg-white p-6 shadow-xl">

                            <div class="mb-4 flex justify-center">
                                <div class="flex h-14 w-14 items-center justify-center rounded-full bg-red-100 text-red-600">
                                    <svg class="h-10 w-10" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            stroke-width="1.3"
                                            d="M6 7h12m-10 0V5h8v2m-9 2 1 11h8l1-11M10 11v5m4-5v5" />
                                    </svg>
                                </div>
                            </div>

                            <h3 class="text-center text-lg font-semibold text-slate-800">
                                ¿Estás seguro de eliminar tu cuenta?
                            </h3>

                            <p class="mt-2 text-center text-sm text-slate-500">
                                Esta acción es permanente y no podrás recuperar el acceso a tu cuenta.
                            </p>

                            <div class="mt-6 flex justify-center gap-3">

                                <button type="button"
                                    onclick="document.getElementById('modalEliminarCuenta').classList.add('hidden'); document.getElementById('modalEliminarCuenta').classList.remove('flex')"
                                    class="rounded-lg border border-slate-300 px-4 py-2 text-sm font-semibold text-slate-700 transition hover:bg-slate-100">
                                    Cancelar
                                </button>

                                <form action="{{ route('perfil.desactivar') }}" method="POST">
                                    @csrf

                                    <button type="submit"
                                        class="inline-flex items-center gap-2 rounded-lg bg-red-600 px-4 py-2 text-sm font-semibold text-white transition hover:bg-red-700">
                                        <i class="fa-solid fa-trash"></i>
                                        Sí, eliminar
                                    </button>
                                </form>

                            </div>
                        </div>
                    </div>

                </div>

            </div>

        @endif

    </div>

@endsection
