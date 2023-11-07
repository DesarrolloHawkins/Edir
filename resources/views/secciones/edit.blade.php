@extends('layouts.app')

@section('title', 'Ver/Editar secciones')

@section('head')
    {{-- @vite(['resources/sass/productos.scss'])
    @vite(['resources/sass/alumnos.scss']) --}}

@section('content-principal')
<div>
    @livewire('secciones.edit-component', ['identificador'=>$id])
</div>
@endsection


