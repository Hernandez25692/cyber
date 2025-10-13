@extends('errors.layout')

@section('title', 'Sesión expirada')
@section('code', '419')
@section('message')
    Tu sesión ha expirado o el formulario tardó demasiado tiempo. Recarga la página e inténtalo de nuevo.
@endsection
