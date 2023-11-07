@extends('layouts.app')

@section('title', 'Nueva sección')

@section('head')
    {{-- @vite(['resources/sass/productos.scss'])
    @vite(['resources/sass/alumnos.scss']) --}}

@section('content-principal')
<div>
    @livewire('secciones.create-component')
</div>
@endsection


