@extends('layouts.app')

@section('title', 'Todas las comunidades')

@section('head')
    @vite(['resources/sass/productos.scss'])
    @vite(['resources/sass/alumnos.scss'])
@endsection

@section('content-principal')
<div>
    @livewire('comunidad.index-admin-component')
</div>
@endsection




