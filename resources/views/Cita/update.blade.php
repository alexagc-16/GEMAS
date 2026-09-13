@extends('layouts.app')


@section('title')
    Actualizar Cita
@endsection


@section('content')

    <div class="container mx-auto mt-10">

        <div class="max-w-xl mx-auto bg-white shadow-lg rounded-lg p-8">

            <h2 class="text-3xl font-bold text-center mb-6">

                Editar Cita

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

            <form action="{{ route('cita.update', $cita->id)}}" method="post">
            @csrf
            @method('PUT')
                
                
               <div class="mb-5">
                    <label for="" class="block mb-2 font-semibold">Fecha</label>
                    <input type="date" name="fecha" value="{{ $cita->fecha}}" class="w-full border rounded px-3 py-2">
                </div>

                <div class="mb-5">
                    <label for="" class="block mb-2 font-semibold">Hora</label>
                    <input type="time" name="hora" value="{{ \Carbon\Carbon::parse($cita->hora)->format('H:i')}}" class="w-full border rounded px-3 py-2">
                </div>

                <div class="mb-5">
                    <label for="" class="block mb-2 font-semibold">Motivo</label>
                    <input type="text" name="motivo" value="{{ $cita->motivo}}" class="w-full border rounded px-3 py-2">
                </div>

                <div class="mb-5">
                    <label for="" class="block mb-2 font-semibold">Estado</label>
                    <select name="estado" id="estado" class="w-full border rounded px-3 py-2">
                        <option value="Pendiente" {{$cita->estado == 'Pendiente' ? 'selected':' ';}}>Pendiente</option>
                        <option value="Confirmada" {{$cita->estado == 'Confirmada' ? 'selected':' ';}}>Confirmada</option>
                        <option value="Atendida" {{$cita->estado == 'Atendida' ? 'selected':' ';}}>Atendida</option>
                        <option value="Cancelada" {{$cita->estado == 'Cancelada' ? 'selected':' ';}}>Cancelada</option>
                    </select>
                </div>

                <div class="mb-5">
                    <label for="" class="block mb-2 font-semibold">Mascota</label>
                    <select name="idMascota" id="idMascota" value="{{ $cita->idMascota}}" class="w-full border rounded px-3 py-2">
                        @foreach ($mascotas as $mascota)
                            <option value="{{$mascota->id}}" {{$mascota->id ==  $cita->idMascota ? 'selected':' ';}}> 
                                {{$mascota->nombre}}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-5">
                    <label for="" class="block mb-2 font-semibold">Veterinario</label>
                    <select name="idVeterinario" id="idVeterinario" value="{{ $cita->idVeterinario}}" class="w-full border rounded px-3 py-2">
                        @foreach ($veterinarios as $veterinario)
                            <option value="{{$veterinario->id}}" {{$veterinario->id ==  $cita->idVeterinario ? 'selected':' ';}}> 
                                {{$veterinario->nombre}}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-5">
                    <label for="" class="block mb-2 font-semibold">Servicio</label>
                    <select name="idServicio" id="idServicioo" value="{{ $cita->idServicio}}" class="w-full border rounded px-3 py-2">
                        @foreach ($servicios as $servicio)
                            <option value="{{$servicio->id}}" {{$servicio->id ==  $cita->idServicio ? 'selected':' ';}}> 
                                {{$servicio->nombre}}
                            </option>
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