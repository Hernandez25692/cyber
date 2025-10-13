@extends('errors.layout')

@section('title', 'Autenticación requerida')
@section('code', '401')
@section('message')
Necesitas iniciar sesión para continuar.
@endsection

@section('actions')
    <div class="flex gap-3">
        <a href="{{ route('login') }}" class="px-4 py-2 rounded-lg bg-blue-600 text-white hover:bg-blue-700">Iniciar sesión</a>
        <a href="{{ url()->previous() }}" class="px-4 py-2 rounded-lg bg-gray-100 text-gray-700 hover:bg-gray-200">Volver atrás</a>
    </div>
@endsection
