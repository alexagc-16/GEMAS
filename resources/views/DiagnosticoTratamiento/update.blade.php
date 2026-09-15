@extends('layouts.app')


@section('title')
    Actualizar Diagnostico y Tratamiento
@endsection


@section('content')

    <div class="container mx-auto mt-10">

        <div class="max-w-xl mx-auto bg-white shadow-lg rounded-lg p-8">

            <h2 class="text-3xl font-bold text-center mb-6">

                Editar Diagnostico y Tratamiento

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

            <form action="{{ route('diagnosticotratamiento.update', $diagnosticoTratamiento->id)}}" method="post">
            @csrf
            @method('PUT')
                
                <div class="mb-5">
                    <label for="" class="block mb-2 font-semibold">Diagnostico</label>
                    <input type="text" name="diagnostico" value="{{ $diagnosticoTratamiento->diagnostico}}" class="w-full border rounded px-3 py-2">
                </div>

                <div class="mb-5">
                    <label for="" class="block mb-2 font-semibold">Tratamiento</label>
                    <input type="text" name="tratamiento" value="{{ $diagnosticoTratamiento->tratamiento}}" class="w-full border rounded px-3 py-2">
                </div>

                <div class="mb-5">
                    <label for="" class="block mb-2 font-semibold">Medicamento</label>
                    <input type="text" name="medicamento" value="{{ $diagnosticoTratamiento->medicamento}}" class="w-full border rounded px-3 py-2">
                </div>

                <div class="mb-5">
                    <label for="" class="block mb-2 font-semibold">Dosis</label>
                    <input type="text" name="dosis" value="{{ $diagnosticoTratamiento->dosis}}" class="w-full border rounded px-3 py-2">
                </div>

                <div class="mb-5">
                    <label for="" class="block mb-2 font-semibold">Frecuencia</label>
                    <input type="text" name="frecuencia" value="{{ $diagnosticoTratamiento->frecuencia}}" class="w-full border rounded px-3 py-2">
                </div>

                <div class="mb-5">
                    <label for="" class="block mb-2 font-semibold">Duracion</label>
                    <input type="text" name="duracion" value="{{ $diagnosticoTratamiento->duracion}}" class="w-full border rounded px-3 py-2">
                </div>

                <div class="mb-5">
                    <label for="" class="block mb-2 font-semibold">Procedimiento</label>
                    <input type="text" name="procedimiento" value="{{ $diagnosticoTratamiento->procedimiento}}" class="w-full border rounded px-3 py-2">
                </div>

                <div class="mb-5">
                    <label for="" class="block mb-2 font-semibold">Examen Ordenado</label>
                    <input type="text" name="examenOrdenado" value="{{ $diagnosticoTratamiento->examenOrdenado}}" class="w-full border rounded px-3 py-2">
                </div>

                <div class="mb-5">
                    <label for="" class="block mb-2 font-semibold">Indicaciones</label>
                    <input type="text" name="indicaciones" value="{{ $diagnosticoTratamiento->indicaciones}}" class="w-full border rounded px-3 py-2">
                </div>

                <div class="mb-5">
                    <label for="" class="block mb-2 font-semibold">Fecha</label>
                    <input type="date" name="fecha" value="{{ $diagnosticoTratamiento->fecha}}" class="w-full border rounded px-3 py-2">
                </div>

                <div class="mb-5">
                    <label for="" class="block mb-2 font-semibold">Evolucion</label>
                    <select name="idEvolucion" id="idEvolucion" value="{{ $diagnosticoTratamiento->idEvolucion}}" class="w-full border rounded px-3 py-2">
                        @foreach ($evoluciones as $evolucion)
                            <option value="{{$evolucion->id}}" {{$evolucion->id ==  $diagnosticoTratamiento->idEvolucion ? 'selected':' ';}}> 
                                {{$evolucion->observaciones}}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="flex items-center justify-end gap-3">

                    <a href="{{ route('diagnosticotratamiento.index') }}" class="rounded-lg border border-slate-300 px-4 py-2.5 text-sm font-semibold text-slate-700 hover:bg-slate-50">Cancelar</a>

                    <button type="submit" class="rounded-lg bg-primary-600 px-4 py-2.5 text-sm font-semibold text-white hover:bg-primary-700 transition">Guardar</button>
                    
                </div>
            
            </form>

        </div>

    </div>

@endsection