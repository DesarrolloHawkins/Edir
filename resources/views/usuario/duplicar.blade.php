@extends('layouts.app')

@section('title', 'Clonar Usuario')

@section('head')
    @vite(['resources/sass/productos.scss'])
    @vite(['resources/sass/alumnos.scss'])
@endsection

@section('content-principal')
<div>
    @livewire('usuarios.duplicar-component', ['identificador'=>$id])
</div>

@endsection

