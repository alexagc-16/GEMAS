@extends('layouts.app')


@section('title')
    Crud Usuario
@endsection


@section('content')


    <div class="container mx-auto mt-10">

        <div class="bg-white shadow-lg rounded-lg p-6">

            <div class="flex justify-between items-center mb-6">

                <h2 class="text-2xl font-bold text-gray-700">
                    Listado de Usuarios
                </h2>

                <a href="{{ route('usuario.create') }}"
                class="rounded-lg bg-primary-600 px-4 py-2.5 text-sm font-semibold text-white hover:bg-primary-700 transition">

                    Nuevo Usuario

                </a>

            </div>

            @if(session('success'))

                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">

                    {{ session('success') }}

                </div>

            @endif

            @if(session('update'))

                <div class="bg-blue-100 border border-blue-400 text-blue-700 px-4 py-3 rounded mb-4">

                    {{ session('update') }}

                </div>

            @endif

            @if(session('destroy'))

                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">

                    {{ session('destroy') }}

                </div>

            @endif

            <table class="min-w-full border border-gray-300">

                <thead class="bg-gray-200">

                    <tr>

                        <th class="border px-4 py-2">
                            ID
                        </th>

                        <th class="border px-4 py-2">
                            Nombre
                        </th>

                        <th class="border px-4 py-2">
                            Apellido
                        </th>

                        <th class="border px-4 py-2">
                            Documento de Identidad
                        </th>

                        <th class="border px-4 py-2">
                            Telefono
                        </th>

                        <th class="border px-4 py-2">
                            Correo
                        </th>

                        <th class="border px-4 py-2">
                            Direccion
                        </th>

                        <th class="border px-4 py-2">
                            Acciones
                        </th>

                    </tr>

                </thead>

                <tbody>

                    @foreach ($usuarios as $usuario)

                        <tr class="text-center hover:bg-gray-50">
                            <td class="border px-4 py-2">{{ $usuario->id }}</td>
                            <td class="border px-4 py-2">{{ $usuario->nombre}}</td>
                            <td class="border px-4 py-2">{{ $usuario->apellido}}</td>
                            <td class="border px-4 py-2">{{ $usuario->documentoIdentidad}}</td>
                            <td class="border px-4 py-2">{{ $usuario->telefono}}</td>
                            <td class="border px-4 py-2">{{ $usuario->correo}}</td>
                            <td class="border px-4 py-2">{{ $usuario->direccion}}</td>
                            
                            <td class="border px-4 py-2">
                                <a href="{{ route('usuario.edit',$usuario->id) }}"class="bg-blue-400 hover:bg-blue-600 text-white rounded px-2 py-2">Editar</a>
                                
                                <form action="{{ route('usuario.destroy', $usuario ->id)}}" method="post">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="bg-red-400 hover:bg-red-600 text-white rounded px-2 py-2">Eliminar</button>
                                </form>
                                


                            </td>
                        </tr>
                        
                    @endforeach

                    @if ($usuarios->isEmpty())

                    <tr>

                        <td colspan="8" class="border px-4 py-6 text-center text-gray-500">
                            No hay usuarios registrados.
                        </td>

                    </tr>

                    @endif


                </tbody>

                
                
                

            </table>

        </div>

    </div>



@endsection