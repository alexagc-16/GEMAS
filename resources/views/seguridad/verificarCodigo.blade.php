@extends('seguridad.layout-auth')

@section('title', 'Verificar código')

@section('content')

    {{-- Contenedor principal --}}
    <main class="min-h-screen flex flex-col items-center justify-center bg-slate-50 px-4 py-4">
        <div class="w-full max-w-md">

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

                {{-- Encabezado --}}
                <h2 class="text-lg font-semibold text-slate-900">
                    Verificar código
                </h2>

                <p class="text-sm text-slate-500 mb-5">
                    Ingresa el código de seis dígitos que enviamos a tu correo electrónico.
                    Recuerda que tiene una vigencia de 10 minutos.
                </p>

                {{-- Mensaje de confirmacion --}}
                @if (session('status'))
                    <div class="mb-4 rounded-md bg-green-50 border border-green-200 p-3 text-sm text-green-700">
                        {{ session('status') }}
                    </div>
                @endif

                {{-- Formulario --}}
                <form action="{{ route('password.codigo.verificar') }}" method="POST" class="space-y-4">
                    @csrf

                    {{-- Codigo de verificacion --}}
                    <div>
                        <label for="codigo" class="block text-sm font-medium text-slate-700 mb-1">
                            Código de verificación
                        </label>

                        <input
                            type="text"
                            name="codigo"
                            id="codigo"
                            inputmode="numeric"
                            pattern="[0-9]{6}"
                            maxlength="6"
                            minlength="6"
                            autocomplete="one-time-code"
                            placeholder="000000"
                            required
                            autofocus
                            class="w-full rounded-md border border-slate-300 shadow-sm focus:border-primary-500 focus:ring-primary-500 px-3 py-3 text-center text-2xl tracking-[0.5em] font-semibold @error('codigo') border-red-500 @enderror"
                        >

                        @error('codigo')
                            <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Boton --}}
                    <button
                        type="submit"
                        class="w-full inline-flex items-center justify-center rounded-lg bg-primary-600 hover:bg-primary-700 text-white text-sm font-semibold px-5 py-2.5 transition"
                    >
                        Verificar código
                    </button>
                </form>

                {{-- Solicitar otro codigo --}}
                <div class="mt-5 text-center">
                    <a
                        href="{{ route('password.request') }}"
                        class="text-sm text-primary-600 hover:text-primary-800 font-medium transition"
                    >
                        Solicitar otro código
                    </a>
                </div>

            </div>
        </div>
    </main>

@endsection
