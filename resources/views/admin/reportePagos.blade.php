@extends('adminlte::page')

@section('title', 'Agenda')

@section('content_header')
    <h1>Reporte de pagos </h1>
@stop

@section('content')
    <div id="app">
         <reporte-pagos/>
    </div>
@stop

@section('css')
    @vite('resources/css/app.css')
@stop

@section('js')
@vite('resources/js/app.js')
@stop