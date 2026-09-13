@extends('layouts.app')


@section('title')
    Crear Cita
@endsection


@section('content')


    <div class="container mx-auto mt-10">

        <div class="max-w-xl mx-auto bg-white shadow-lg rounded-lg p-8">

            <h2 class="text-2xl font-bold text-center mb-6">
                Nueva Cita
            </h2>

            <p class="mt-1 text-sm text-center">
            Registra una nueva cita.
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

            <form action="{{ route('cita.store')}}" method="post">
            @csrf

                <div class="mb-5">
                    <label for="" class="block mb-2 font-semibold">Fecha</label>
                    <input type="date" name="fecha" class="w-full border rounded px-3 py-2">
                </div>

                <div class="mb-5">
                    <label for="" class="block mb-2 font-semibold">Hora</label>
                    <input type="time" name="hora" class="w-full border rounded px-3 py-2">
                </div>

                <div class="mb-5">
                    <label for="" class="block mb-2 font-semibold">Motivo</label>
                    <input type="text" name="motivo" class="w-full border rounded px-3 py-2">
                </div>

                <div class="mb-5">
                    <label for="" class="block mb-2 font-semibold">Estado</label>
                    <select name="estado" id="estado" class="w-full border rounded px-3 py-2">
                        <option value="Pendiente">Pendiente</option>
                        <option value="Confirmada">Confirmada</option>
                        <option value="Atendida">Atendida</option>
                        <option value="Cancelada">Cancelada</option>
                    </select>
                </div>

                <div class="mb-5">
                    <label for="" class="block mb-2 font-semibold">Mascota</label>
                    <select name="idMascota" id="idMascota" class="w-full border rounded px-3 py-2">
                        @foreach ($mascotas as $mascota)
                            <option value="{{$mascota->id}} "> {{$mascota->nombre}} </option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-5">
                    <label for="" class="block mb-2 font-semibold">Veterinario</label>
                    <select name="idVeterinario" id="idVeterinario" class="w-full border rounded px-3 py-2">
                        @foreach ($veterinarios as $veterinario)
                            <option value="{{$veterinario->id}} "> {{$veterinario->nombre}} </option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-5">
                    <label for="" class="block mb-2 font-semibold">Servicio</label>
                    <select name="idServicio" id="idServicio" class="w-full border rounded px-3 py-2">
                        @foreach ($servicios as $servicio)
                            <option value="{{$servicio->id}} "> {{$servicio->nombre}} </option>
                        @endforeach
                    </select>
                </div>

                <div class="flex items-center justify-end gap-3">

                    <a href="{{ route('cita.index') }}" class="rounded-lg border border-slate-300 px-4 py-2.5 text-sm font-semibold text-slate-700 hover:bg-slate-50">Cancelar</a>

                    <button type="submit" class="rounded-lg bg-primary-600 px-4 py-2.5 text-sm font-semibold text-white hover:bg-primary-700 transition">Guardar</button>
                </div>
            
            </form>

        </div>

    </div>

@endsection