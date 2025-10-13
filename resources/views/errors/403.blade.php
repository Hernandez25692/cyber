@extends('errors.layout')

@section('title', 'Acceso no autorizado')
@section('code', '403')
@section('message')
    No tienes permisos para acceder a esta sección. Si crees que es un error, contacta al administrador del sistema.
@endsection
