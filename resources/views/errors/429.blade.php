@extends('errors.layout')

@section('title', 'Demasiadas solicitudes')
@section('code', '429')
@section('message')
    Has realizado demasiadas solicitudes en poco tiempo. Por favor, espera un momento e inténtalo nuevamente.
@endsection
