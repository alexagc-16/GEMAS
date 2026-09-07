@extends('layouts.app')


@section('title')
    Actualizar Historia Clinica
@endsection


@section('content')

    <div class="container mx-auto mt-10">

        <div class="max-w-xl mx-auto bg-white shadow-lg rounded-lg p-8">

            <h2 class="text-3xl font-bold text-center mb-6">

                Editar Historia Clinica

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

            <form action="{{ route('historiaclinica.update', $historiaClinica->id)}}" method="post">
            @csrf
            @method('PUT')
                
                
               <div class="mb-5">
                    <label for="" class="block mb-2 font-semibold">Fecha de Apertura</label>
                    <input type="date" name="fechaApertura" value="{{ $historiaClinica->fechaApertura}}" class="w-full border rounded px-3 py-2">
                </div>

                <div class="mb-5">
                    <label for="" class="block mb-2 font-semibold">Antecedentes</label>
                    <input type="text" name="antecedentes" value="{{ $historiaClinica->antecedentes}}" class="w-full border rounded px-3 py-2">
                </div>

                <div class="mb-5">
                    <label for="" class="block mb-2 font-semibold">Alergias</label>
                    <input type="text" name="alergias" value="{{ $historiaClinica->alergias}}" class="w-full border rounded px-3 py-2">
                </div>

                <div class="mb-5">
                    <label for="" class="block mb-2 font-semibold">Enfermedades Previas</label>
                    <input type="text" name="enfermedadesPrevias" value="{{ $historiaClinica->enfermedadesPrevias}}" class="w-full border rounded px-3 py-2">
                </div>

                <div class="mb-5">
                    <label for="" class="block mb-2 font-semibold">Observaciones</label>
                    <input type="text" name="observaciones" value="{{ $historiaClinica->observaciones}}" class="w-full border rounded px-3 py-2">
                </div>

                <div class="mb-5">
                    <label for="" class="block mb-2 font-semibold">Mascota</label>
                    <select name="idMascota" id="idMascota" value="{{ $historiaClinica->idMascota}}" class="w-full border rounded px-3 py-2">
                        @foreach ($mascotas as $mascota)
                            <option value="{{$mascota->id}}" {{$mascota->id ==  $historiaClinica->idMascota ? 'selected':' ';}}> 
                                {{$mascota->nombre}}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="flex items-center justify-end gap-3">

                    <a href="{{ route('historiaclinica.index') }}" class="rounded-lg border border-slate-300 px-4 py-2.5 text-sm font-semibold text-slate-700 hover:bg-slate-50">Cancelar</a>

                    <button type="submit" class="rounded-lg bg-primary-600 px-4 py-2.5 text-sm font-semibold text-white hover:bg-primary-700 transition">Guardar</button>
                    
                </div>
            
            </form>

        </div>

    </div>

@endsection