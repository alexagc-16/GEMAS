@extends('layouts.app')


@section('title')
    Actualizar Evolucion
@endsection


@section('content')

    <div class="container mx-auto mt-10">

        <div class="max-w-xl mx-auto bg-white shadow-lg rounded-lg p-8">

            <h2 class="text-3xl font-bold text-center mb-6">

                Editar Evolucion

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

            <form action="{{ route('evolucion.update', $evolucion->id)}}" method="post">
            @csrf
            @method('PUT')
                
                
               <div class="mb-5">
                    <label for="" class="block mb-2 font-semibold">Fecha</label>
                    <input type="date" name="fecha" value="{{ $evolucion->fecha}}" class="w-full border rounded px-3 py-2">
                </div>

                <div class="mb-5">
                    <label for="" class="block mb-2 font-semibold">Peso</label>
                    <input type="number" name="peso" step="0.01" value="{{ $evolucion->peso}}" class="w-full border rounded px-3 py-2">
                </div>

                <div class="mb-5">
                    <label for="" class="block mb-2 font-semibold">Temperatura</label>
                    <input type="number" name="temperatura" step="0.01" value="{{ $evolucion->temperatura}}" class="w-full border rounded px-3 py-2">
                </div>

                <div class="mb-5">
                    <label for="" class="block mb-2 font-semibold">Sintomas</label>
                    <input type="text" name="sintomas" value="{{ $evolucion->sintomas}}" class="w-full border rounded px-3 py-2">
                </div>

                <div class="mb-5">
                    <label for="" class="block mb-2 font-semibold">Observaciones</label>
                    <input type="text" name="observaciones" value="{{ $evolucion->observaciones}}" class="w-full border rounded px-3 py-2">
                </div>
                
                <div class="mb-5">
                    <label for="" class="block mb-2 font-semibold">Historia Clinica</label>
                    <select name="idHistoriaClinica" id="idHistoriaClinica" value="{{ $evolucion->idHistoriaClinica}}" class="w-full border rounded px-3 py-2">
                        @foreach ($historiasClinicas as $historiaClinica)
                            <option value="{{$historiaClinica->id}}" {{$historiaClinica->id ==  $evolucion->idHistoriaClinica ? 'selected':' ';}}> 
                                {{$historiaClinica->id}}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-5">
                    <label for="" class="block mb-2 font-semibold">Veterinario</label>
                    <select name="idVeterinario" id="idVeterinario" value="{{ $evolucion->idVeterinario}}" class="w-full border rounded px-3 py-2">
                        @foreach ($veterinarios as $veterinario)
                            <option value="{{$veterinario->id}}" {{$veterinario->id ==  $evolucion->idVeterinario ? 'selected':' ';}}> 
                                {{$veterinario->nombre}}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="flex items-center justify-end gap-3">

                    <a href="{{ route('evolucion.index') }}" class="rounded-lg border border-slate-300 px-4 py-2.5 text-sm font-semibold text-slate-700 hover:bg-slate-50">Cancelar</a>

                    <button type="submit" class="rounded-lg bg-primary-600 px-4 py-2.5 text-sm font-semibold text-white hover:bg-primary-700 transition">Guardar</button>
                    
                </div>
            
            </form>

        </div>

    </div>

@endsection