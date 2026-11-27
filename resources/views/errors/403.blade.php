@extends('layouts.app')

@section('content')
<div class="min-h-[70vh] flex items-center justify-center px-4">
    <div class="w-full max-w-lg bg-white rounded-2xl border border-slate-200 shadow-sm p-8 text-center">

        <div class="w-20 h-20 mx-auto flex items-center justify-center rounded-full bg-[#EAF4F5] mb-6">
            <i class="fa-solid fa-shield-halved text-4xl text-[#438195]">
                <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-circle-x preview-icon"><circle cx="12" cy="12" r="10"/><path d="m15 9-6 6"/><path d="m9 9 6 6"/></svg>
            </i>
        </div>

        <h1 class="text-2xl font-bold text-slate-800 mb-3">
            Acceso restringido
        </h1>

        <p class="text-slate-600 mb-2">
            No tienes los permisos necesarios para realizar esta acción.
        </p>

        <p class="text-sm text-slate-500 mb-6">
            Si consideras que deberías tener acceso, comunícate con el administrador del sistema.
        </p>

        <a href="{{ url()->previous() }}"
            class="inline-flex items-center gap-2 px-5 py-2.5 rounded-lg bg-[#438195] hover:bg-[#397184] text-white font-semibold transition">
            Volver
        </a>

    </div>
</div>
@endsection