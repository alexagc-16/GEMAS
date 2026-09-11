@extends('layouts.app')


@section('title')
    Actualizar Veterinario
@endsection


@section('content')

    <div class="container mx-auto mt-10">

        <div class="max-w-xl mx-auto bg-white shadow-lg rounded-lg p-8">

            <h2 class="text-3xl font-bold text-center mb-6">

                Editar Veterinario

            </h2>

            @if($errors->any())

                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-5">

                    <ul>

                        @foreach($errors->all() as $error)

                            <li>{{ $error }}</li>

                        @endforeach

                    </ul>

                </div>

            @endif

            <form action="{{ route('veterinario.update', $veterinario->id)}}" method="post">
            @csrf
            @method('PUT')
                
                
               <div class="mb-5">
                    <label for="" class="block mb-2 font-semibold">Nombre</label>
                    <input type="text" name="nombre" value="{{ $veterinario->nombre}}" class="w-full border rounded px-3 py-2">
                </div>

                <div class="mb-5">
                    <label for="" class="block mb-2 font-semibold">Apellido</label>
                    <input type="text" name="apellido" value="{{ $veterinario->apellido}}" class="w-full border rounded px-3 py-2">
                </div>

                <div class="mb-5">
                    <label for="" class="block mb-2 font-semibold">Documento de Identidad</label>
                    <input type="text" name="documentoIdentidad" value="{{ $veterinario->documentoIdentidad}}" class="w-full border rounded px-3 py-2">
                </div>

                <div class="mb-5">
                    <label for="" class="block mb-2 font-semibold">Telefono</label>
                    <input type="text" name="telefono" value="{{ $veterinario->telefono}}" class="w-full border rounded px-3 py-2">
                </div>

                <div class="mb-5">
                    <label for="" class="block mb-2 font-semibold">Correo</label>
                    <input type="text" name="correo" value="{{ $veterinario->correo}}" class="w-full border rounded px-3 py-2">
                </div>

                <div class="mb-5">
                    <label for="" class="block mb-2 font-semibold">Especialidad</label>
                    <input type="text" name="especialidad" value="{{ $veterinario->especialidad}}" class="w-full border rounded px-3 py-2">
                </div>

                <div class="flex items-center justify-end gap-3">

                    <a href="{{ route('veterinario.index') }}" class="rounded-lg border border-slate-300 px-4 py-2.5 text-sm font-semibold text-slate-700 hover:bg-slate-50">Cancelar</a>

                    <button type="submit" class="rounded-lg bg-primary-600 px-4 py-2.5 text-sm font-semibold text-white hover:bg-primary-700 transition">Guardar</button>
                    
                </div>
            
            </form>

        </div>

    </div>

@endsection