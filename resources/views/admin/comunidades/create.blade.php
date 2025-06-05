@extends('layouts.appUser')

@section('title', 'Crear Comunidad')

@section('content-principal')
<div class="container">
    <h4 class="page-title">CREAR COMUNIDAD</h4>
    <form action="{{ route('comunidades.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="mb-3">
            <label for="nombre" class="form-label">Nombre</label>
            <input type="text" name="nombre" id="nombre" class="form-control" value="{{ old('nombre') }}" required>
        </div>
        <div class="mb-3">
            <label for="direccion" class="form-label">Dirección</label>
            <input type="text" name="direccion" id="direccion" class="form-control" value="{{ old('direccion') }}">
        </div>
        <div class="mb-3">
            <label for="codigo" class="form-label">Código</label>
            <input type="text" name="codigo" id="codigo" class="form-control" value="{{ old('codigo') }}" required>
        </div>
        <div class="mb-3">
            <label for="informacion_adicional" class="form-label">Información Adicional</label>
            <textarea name="informacion_adicional" id="informacion_adicional" class="form-control">{{ old('informacion_adicional') }}</textarea>
        </div>
        <div class="mb-3">
            <label for="ruta_imagen" class="form-label">Imagen</label>
            <input type="file" name="ruta_imagen" id="ruta_imagen" class="form-control">
        </div>
        <button type="submit" class="btn btn-primary">Crear</button>
    </form>
</div>
@endsection
