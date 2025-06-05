@extends('layouts.appUser')

@section('title', 'Crear Usuario')

@section('content-principal')
<div class="container">
    <h4 class="page-title">CREAR USUARIO</h4>
    <form action="{{ route('usuarios.store') }}" method="POST">
        @csrf

        @include('admin.usuarios.form')

        <button type="submit" class="btn btn-primary">Crear</button>
    </form>
</div>
@endsection
