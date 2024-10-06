@extends('adminlte::page')

@section('title', 'Agenda')

@section('content_header')
    <h1>Registro de pagos</h1>
@stop

@section('content')
    <div id="app">
         <pago-component/>
    </div>
@stop

@section('css')
    @vite('resources/css/app.css')
@stop

@section('js')
@vite('resources/js/app.js')
@stop