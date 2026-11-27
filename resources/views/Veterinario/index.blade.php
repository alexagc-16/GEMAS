@extends('layouts.app')

@section('title')
    Veterinarios - Gemas
@endsection

@section('content')

    <div class="w-full max-w-7xl mx-auto space-y-6">

        {{-- Encabezado --}}
        <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <h1 class="text-2xl font-bold text-slate-800">
                    Veterinarios
                </h1>

                <p class="mt-1 text-sm text-slate-500">
                    Consulta la información de los veterinarios registrados.
                </p>
            </div>

            @if(!auth()->user()->hasRole('usuario'))
                <a href="{{ route('veterinario.create') }}"
                    class="inline-flex items-center justify-center gap-2 rounded-xl
                        bg-[#40899A] px-5 py-3 text-sm font-semibold text-white
                        shadow-sm transition hover:bg-[#347787]">

                    <svg class="h-5 w-5" fill="none" stroke="currentColor"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            stroke-width="2" d="M12 4v16m8-8H4"/>
                    </svg>

                    Registrar Veterinario
                </a>
            @endif
        </div>


        {{-- Mensajes del sistema --}}
        @if(session('success'))
            <div class="rounded-lg border border-green-200
                        bg-green-50 px-4 py-3 text-sm text-green-700">
                {{ session('success') }}
            </div>
        @endif

        @if(session('veterinarioRegistrado'))
            <div class="rounded-lg border border-green-200
                        bg-green-50 px-4 py-3 text-sm text-green-700">
                Veterinario registrado correctamente. Se ha enviado el correo para establecer su contraseña.
            </div>
        @endif

        @if(session('warning'))
            <div class="rounded-lg border border-amber-200
                        bg-amber-50 px-4 py-3 text-sm text-amber-700">
                {{ session('warning') }}
            </div>
        @endif

        @if(session('update'))
            <div class="rounded-lg border border-blue-200
                        bg-blue-50 px-4 py-3 text-sm text-blue-700">
                {{ session('update') }}
            </div>
        @endif


        {{-- Filtros --}}
        <x-filtros-tabla
            buscador-id="buscarVeterinario"
            placeholder="Nombre, documento, teléfono, correo o especialidad..."
            contador-id="contadorVeterinarios"
            limpiar-id="limpiarFiltrosVeterinarios"
            :contador-total="$veterinarios->total()"
            :filtros="[
                [
                    'id' => 'filtroEspecialidad',
                    'name' => 'especialidad',
                    'label' => 'Especialidad',
                    'todos' => 'Todas las especialidades',
                    'opciones' => $especialidades
                ]
            ]"
        />


        {{-- Tabla de veterinarios --}}
        <div class="bg-white rounded-xl border border-slate-200
                    shadow-sm overflow-hidden">

            {{-- Encabezado de la tabla --}}
            <div class="border-b border-slate-200 px-6 py-5">
                <h2 class="text-lg font-semibold text-slate-800">
                    Veterinarios registrados
                </h2>

                <p class="mt-1 text-sm text-slate-500">
                    Listado de los profesionales y sus datos principales.
                </p>
            </div>

            <div class="w-full min-w-0 overflow-x-auto">

                @php
                    $hayFiltrosAplicados = collect(request()->query())
                        ->except('page')
                        ->filter(fn ($valor) => filled($valor))
                        ->isNotEmpty();
                @endphp

                <table class="w-full text-sm text-left">

                    <thead class="bg-slate-50 text-slate-500">

                        <tr>

                            @if(auth()->user()->hasRole('administrador'))
                                <th class="px-6 py-3 font-medium">
                                    #
                                </th>
                            @endif

                            <th class="px-6 py-3 font-medium">
                                Veterinario
                            </th>

                            <th class="px-6 py-3 font-medium">
                                Documento
                            </th>

                            <th class="px-6 py-3 font-medium">
                                Teléfono
                            </th>

                            <th class="px-6 py-3 font-medium">
                                Correo electrónico
                            </th>

                            <th class="px-6 py-3 font-medium">
                                Especialidad
                            </th>

                            @if(!auth()->user()->hasRole('usuario'))

                                <th class="px-6 py-3 font-medium text-center">
                                    Acciones
                                </th>
                            
                            @endif

                        </tr>

                    </thead>


                    <tbody class="divide-y divide-slate-100">

                        @forelse($veterinarios as $veterinario)

                            <tr class="hover:bg-slate-50 transition">

                                @if(auth()->user()->hasRole('administrador'))
                                    <td class="px-6 py-4 text-slate-500">
                                        {{ $veterinario->id }}
                                    </td>
                                @endif


                                {{-- Veterinario --}}
                                <td class="px-6 py-4">

                                    <div class="min-w-0">
                                        <p class="font-medium text-slate-700">
                                            {{ $veterinario->nombre }}
                                            {{ $veterinario->apellido }}
                                        </p>
                                    </div>

                                </td>


                                {{-- Documento --}}
                                <td class="px-6 py-4 text-slate-700">
                                    {{ $veterinario->documentoIdentidad }}
                                </td>


                                {{-- Teléfono --}}
                                <td class="px-6 py-4 text-slate-700">
                                    {{ $veterinario->telefono ?: 'No registrado' }}
                                </td>


                                {{-- Correo --}}
                                <td class="px-6 py-4 text-slate-700">
                                    <span class="break-all">
                                        {{ $veterinario->email ?: 'No registrado' }}
                                    </span>
                                </td>


                                {{-- Especialidad --}}
                                <td class="px-6 py-4">
                                    <span class="inline-flex items-center rounded-full
                                                bg-[#EAF4F5] px-3 py-1 text-xs
                                                font-semibold text-[#40899A]">
                                        {{ $veterinario->especialidad }}
                                    </span>
                                </td>


                                {{-- Acciones --}}
                                <td class="px-6 py-4">

                                    <div class="flex items-center justify-center gap-2">

                                        @if(!auth()->user()->hasRole('usuario'))

                                            <a href="{{ route('veterinario.edit', $veterinario->id) }}"
                                                class="inline-flex items-center justify-center gap-1.5 rounded-lg bg-[#EAF4F5] px-3 py-2 text-xs font-semibold text-[#40899A] transition hover:bg-[#d5ebed]"
                                                title="Editar mascota">

                                                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                                                        d="m16.862 4.487 2.651 2.651M4 20l4.5-.9L19.2 8.4a1.875 1.875 0 0 0-2.65-2.65L5.85 16.45 4 20Z"/>
                                                </svg>

                                                Editar
                                            </a>

                                        @endif

                                    </div>

                                </td>

                            </tr>

                        @empty

                            @if ($hayFiltrosAplicados)

                                {{-- Sin resultados de búsqueda --}}
                                <tr>
                                    <td colspan="8" class="px-6 py-10 text-center">

                                        <h3 class="text-lg font-semibold text-slate-700">
                                            No se encontraron resultados
                                        </h3>

                                        <p class="mt-1 text-sm text-slate-500">
                                            No hay veterinarios que coincidan con los filtros aplicados.
                                        </p>

                                    </td>
                                </tr>

                            @else

                                {{-- Sin veterinarios --}}
                                <tr>
                                    <td colspan="8" class="px-6 py-10 text-center">

                                        <div class="mx-auto w-16 h-16 rounded-full bg-[#EAF4F5]
                                                    flex items-center justify-center text-[#40899A]">

                                            @include('layouts.partials.icons', [
                                                'icon' => 'veterinario'
                                            ])

                                        </div>

                                        <h3 class="mt-4 text-lg font-semibold text-slate-800">
                                            No hay veterinarios registrados
                                        </h3>

                                        <p class="mt-2 text-sm text-slate-500">
                                            Cuando registres un veterinario, aparecerá aquí.
                                        </p>

                                        @if(auth()->user()->can('crearveterinario'))
                                            <a href="{{ route('veterinario.create') }}"
                                                class="inline-flex items-center gap-2 mt-5 rounded-lg
                                                    bg-[#40899A] px-4 py-2.5 text-sm font-semibold
                                                    text-white hover:bg-[#347787] transition">

                                                Registrar primer veterinario

                                            </a>
                                        @endif

                                    </td>
                                </tr>

                            @endif

                        @endforelse

                    </tbody>

                </table>

            </div>

        </div>


        {{-- Paginación --}}
        @if($veterinarios->hasPages())

            <div class="border-t border-slate-200 bg-white px-4 py-4 sm:px-6">

                <div class="flex flex-col gap-3 sm:flex-row
                            sm:items-center sm:justify-between">

                    <p class="text-sm text-slate-500">
                        Mostrando

                        <span class="font-semibold text-slate-700">
                            {{ $veterinarios->firstItem() ?? 0 }}
                        </span>

                        a

                        <span class="font-semibold text-slate-700">
                            {{ $veterinarios->lastItem() ?? 0 }}
                        </span>

                        de

                        <span class="font-semibold text-slate-700">
                            {{ $veterinarios->total() }}
                        </span>

                        veterinarios
                    </p>

                    <div>
                        {{ $veterinarios->onEachSide(1)->links('vendor.pagination.gemas') }}
                    </div>

                </div>

            </div>

        @endif

    </div>

    @if(session('veterinarioRegistrado'))
        <div id="modalVeterinarioRegistrado"
            class="fixed inset-0 z-50 flex items-center justify-center bg-black/50 px-4">

            <div class="w-full max-w-md rounded-xl bg-white p-6 shadow-xl">

                <div class="flex justify-center mb-4">
                    <div class="flex h-14 w-14 items-center justify-center rounded-full bg-[#EEF6F8]">
                        <svg class="h-8 w-8 text-[#438195]" fill="none"
                            stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                stroke-width="2"
                                d="M5 13l4 4L19 7"/>
                        </svg>
                    </div>
                </div>

                <h3 class="text-xl font-semibold text-[#306174] text-center mb-3">
                    ¡Veterinario registrado!
                </h3>

                <p class="text-sm text-gray-600 text-center leading-relaxed mb-4">
                    Se ha enviado un correo electrónico con el enlace para establecer su contraseña.
                </p>

                <div class="rounded-lg bg-[#EEF6F8] border border-[#C0E0E6] p-3 mb-5">
                    <p class="text-sm text-[#306174] text-center">
                        Si no encuentra el mensaje en su bandeja de entrada, debe revisar la carpeta de
                        <strong>Spam o correo no deseado.</strong>
                    </p>
                </div>

                <button
                    type="button"
                    onclick="document.getElementById('modalVeterinarioRegistrado').remove()"
                    class="w-full rounded-lg bg-[#4A90A4] hover:bg-[#438195] text-white font-semibold py-2.5 transition">
                    Entendido
                </button>

            </div>
        </div>
    
    @endif

    

@endsection