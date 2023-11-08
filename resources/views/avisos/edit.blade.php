

@extends('layouts.app')

@section('title', 'Comprobar aviso')

@section('head')
    @vite(['resources/sass/productos.scss'])
    @vite(['resources/sass/alumnos.scss'])
@endsection

@section('content-principal')
<div>
    @livewire('avisos.edit-component', ['identificador' => $id])
</div>
@endsection

