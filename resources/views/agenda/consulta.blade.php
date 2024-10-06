@extends('adminlte::page')

@section('title', 'Agenda')

@section('content_header')
    <h1>Healthy Smiles</h1>
@stop

@section('content')
    <div id="app">
         <consulta-component :cita-id="{{ $cita_id }}"/>
    </div>
@stop

@section('css')
    @vite('resources/css/app.css')
@stop

@section('js')
@vite('resources/js/app.js')
@stop