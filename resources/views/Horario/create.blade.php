@extends('layouts.app')


@section('title')
    Crear Horario
@endsection


@section('content')


    <div class="container mx-auto mt-10">

        <div class="max-w-xl mx-auto bg-white shadow-lg rounded-lg p-8">

            <h2 class="text-2xl font-bold text-center mb-6">
                Nuevo Horario
            </h2>

            <p class="mt-1 text-sm text-center">
            Registra una nuevo horario.
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

            <form action="{{ route('horario.store')}}" method="post">
            @csrf

                <div class="mb-5">
                    <label for="" class="block mb-2 font-semibold">Dia de la Semana</label>
                    <input type="text" name="diaSemana" class="w-full border rounded px-3 py-2">
                </div>

                <div class="mb-5">
                    <label for="" class="block mb-2 font-semibold">Hora de Inicio</label>
                    <input type="time" name="horaInicio" class="w-full border rounded px-3 py-2">
                </div>

                <div class="mb-5">
                    <label for="" class="block mb-2 font-semibold">Hora de Fin</label>
                    <input type="time" name="horaFin" class="w-full border rounded px-3 py-2">
                </div>

                <div class="mb-5">
                    <label for="" class="block mb-2 font-semibold">Veterinario</label>
                    <select name="idVeterinario" id="idVeterinario" class="w-full border rounded px-3 py-2">
                        @foreach ($veterinarios as $veterinario)
                            <option value="{{$veterinario->id}} "> {{$veterinario->nombre}} </option>
                        @endforeach
                    </select>
                </div>

                

                <div class="flex items-center justify-end gap-3">

                    <a href="{{ route('horario.index') }}" class="rounded-lg border border-slate-300 px-4 py-2.5 text-sm font-semibold text-slate-700 hover:bg-slate-50">Cancelar</a>

                    <button type="submit" class="rounded-lg bg-primary-600 px-4 py-2.5 text-sm font-semibold text-white hover:bg-primary-700 transition">Guardar</button>
                </div>
            
            </form>

        </div>

    </div>

@endsection