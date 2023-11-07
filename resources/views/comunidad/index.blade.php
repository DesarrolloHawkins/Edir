@extends('layouts.app')

@section('title', 'Datos de tu comunidad')

@section('head')
    @vite(['resources/sass/productos.scss'])
    @vite(['resources/sass/alumnos.scss'])
@endsection

@section('content-principal')
<div>
    @livewire('comunidad.index-component')
</div>
@endsection




