@extends('adminlte::page')

@section('title', 'Agenda')

@section('content_header')
    <h1>Pacientes</h1>
@stop

@section('content')
    <div id="app">
         <paciente-component/>
    </div>
@stop

@section('css')
    @vite('resources/css/app.css')
@stop

@section('js')
@vite('resources/js/app.js')
@stop