@extends('layouts.appUser')

@section('title', 'Editar Comunidad')

@section('content-principal')
<div class="container">
    <h4 class="page-title">EDITAR COMUNIDAD</h4>
    <form action="{{ route('comunidades.update', $comunidad->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="nombre" class="form-label">Nombre</label>
            <input type="text" name="nombre" id="nombre" class="form-control" value="{{ old('nombre', $comunidad->nombre) }}" required>
        </div>
        <div class="mb-3">
            <label for="direccion" class="form-label">Dirección</label>
            <input type="text" name="direccion" id="direccion" class="form-control" value="{{ old('direccion', $comunidad->direccion) }}">
        </div>
        <div class="mb-3">
            <label for="codigo" class="form-label">Código</label>
            <input type="text" name="codigo" id="codigo" class="form-control" value="{{ old('codigo', $comunidad->codigo) }}" required>
        </div>
        <div class="mb-3">
            <label for="informacion_adicional" class="form-label">Información Adicional</label>
            <textarea name="informacion_adicional" id="informacion_adicional" class="form-control">{{ old('informacion_adicional', $comunidad->informacion_adicional) }}</textarea>
        </div>
        <div class="mb-3">
            <label for="ruta_imagen" class="form-label">Imagen</label>
            <input type="file" name="ruta_imagen" id="ruta_imagen" class="form-control">
            @if($comunidad->ruta_imagen)
                <img src="{{ asset('storage/'.$comunidad->ruta_imagen) }}" alt="Imagen de la comunidad" class="mt-3" width="150">
            @endif
        </div>
        <button type="submit" class="btn btn-primary">Actualizar</button>
    </form>
</div>
@endsection
