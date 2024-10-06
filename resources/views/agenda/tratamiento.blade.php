@extends('adminlte::page')

@section('title', 'Agenda')

@section('content_header')
    <h1>Tratamientos</h1>
@stop

@section('content')
    <div id="app">
         <tratamiento-component/>
    </div>
@stop

@section('css')
    @vite('resources/css/app.css')
@stop

@section('js')
@vite('resources/js/app.js')
@stop