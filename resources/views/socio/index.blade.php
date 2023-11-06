@extends('layouts.app')

@section('title', 'Ver socios')

@section('head')
    {{-- @vite(['resources/sass/productos.scss'])
    @vite(['resources/sass/alumnos.scss']) --}}

@section('content-principal')
<div>
    @livewire('socio.index-component')
</div>
@endsection


