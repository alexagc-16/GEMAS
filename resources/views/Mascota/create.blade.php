@extends('layouts.app')


@section('title')
    Crear Mascota
@endsection


@section('content')


    <div class="container mx-auto mt-10">

        <div class="max-w-xl mx-auto bg-white shadow-lg rounded-lg p-8">

            <h2 class="text-2xl font-bold text-center mb-6">
                Nueva Mascota
            </h2>

            <p class="mt-1 text-sm text-center">
            Registra una nueva mascota.
            </p>

            <br>
        

            @if($errors->any())

                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-5">

                    <ul>

                        @foreach($errors->all() as $error)

                            <li>{{ $error }}</li>

                        @endforeach

                    </ul>

                </div>

            @endif

            <form action="{{ route('mascota.store')}}" method="post">
            @csrf

                <div class="mb-5">
                    <label for="" class="block mb-2 font-semibold">Nombre</label>
                    <input type="text" name="nombre" class="w-full border rounded px-3 py-2">
                </div>

                <div class="mb-5">
                    <label for="" class="block mb-2 font-semibold">Especie</label>
                    <input type="text" name="especie" class="w-full border rounded px-3 py-2">
                </div>

                <div class="mb-5">
                    <label for="" class="block mb-2 font-semibold">Raza</label>
                    <input type="text" name="raza" class="w-full border rounded px-3 py-2">
                </div>

                <div class="mb-5">
                    <label for="" class="block mb-2 font-semibold">Sexo</label>
                    <select name="sexo" id="sexo" class="w-full border rounded px-3 py-2">
                        <option value="1">Macho</option>
                        <option value="0">Hembra</option>
                    </select>
                </div>

                <div class="mb-5">
                    <label for="" class="block mb-2 font-semibold">Fecha de Nacimiento</label>
                    <input type="date" name="fechaNacimiento" class="w-full border rounded px-3 py-2">
                </div>

                <div class="mb-5">
                    <label for="" class="block mb-2 font-semibold">Color</label>
                    <input type="text" name="color" class="w-full border rounded px-3 py-2">
                </div>

                <div class="mb-5">
                    <label for="" class="block mb-2 font-semibold">Peso</label>
                    <input type="number" name="peso" step="0.01" class="w-full border rounded px-3 py-2">
                </div>

                <div class="mb-5">
                    <label for="" class="block mb-2 font-semibold">Usuario</label>
                    <select name="idUsuario" id="idUsuario" class="w-full border rounded px-3 py-2">
                        @foreach ($usuarios as $usuario)
                            <option value="{{$usuario->id}} "> {{$usuario->nombre}} </option>
                        @endforeach
                    </select>
                </div>

                

                <div class="flex items-center justify-end gap-3">

                    <a href="{{ route('mascota.index') }}" class="rounded-lg border border-slate-300 px-4 py-2.5 text-sm font-semibold text-slate-700 hover:bg-slate-50">Cancelar</a>

                    <button type="submit" class="rounded-lg bg-primary-600 px-4 py-2.5 text-sm font-semibold text-white hover:bg-primary-700 transition">Guardar</button>
                </div>
            
            </form>

        </div>

    </div>

@endsection