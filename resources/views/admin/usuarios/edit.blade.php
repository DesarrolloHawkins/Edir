@extends('layouts.appUser')

@section('title', 'Editar Usuario')

@section('content-principal')
<div class="container">
    <h4 class="page-title">EDITAR USUARIO</h4>
    <form action="{{ route('usuarios.update', $usuario->id) }}" method="POST">
        @csrf
        @method('PUT')

        @include('admin.usuarios.form', ['usuario' => $usuario])

        <button type="submit" class="btn btn-primary">Actualizar</button>
    </form>
</div>
@endsection
