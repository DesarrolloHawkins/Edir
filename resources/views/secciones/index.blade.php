@extends('layouts.app')

@section('title', 'Administrar secciones')

@section('head')
    {{-- @vite(['resources/sass/productos.scss'])
    @vite(['resources/sass/alumnos.scss']) --}}

@section('content-principal')
<div>
    @livewire('secciones.index-component')
</div>
@endsection


