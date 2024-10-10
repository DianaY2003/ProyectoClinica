@extends('adminlte::page')

@section('title', 'Agenda')

@section('content_header')
    <h1>Reporte de Citas</h1> <!-- Título adaptado -->
@stop

@section('content')
    <div id="app">
        <reporte-citas/> <!-- Componente para el reporte de citas -->
    </div>
@stop

@section('css')
    @vite('resources/css/app.css') <!-- Carga de estilos -->
@stop

@section('js')
    @vite('resources/js/app.js') <!-- Carga de scripts -->
@stop
