@extends('layouts.app')

@section('title', 'Ver/Editar socio')

@section('head')
    {{-- @vite(['resources/sass/productos.scss'])
    @vite(['resources/sass/alumnos.scss']) --}}

@section('content-principal')
<div>
    @livewire('socio.edit-component', ['identificador'=>$id])
</div>
@endsection


