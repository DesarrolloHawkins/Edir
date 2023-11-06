@extends('layouts.app')

@section('title', 'Añadir socio')

@section('head')
    {{-- @vite(['resources/sass/productos.scss'])
    @vite(['resources/sass/alumnos.scss']) --}}

@section('content-principal')
<div>
    @livewire('socio.create-component')
</div>
@endsection


