@extends('layouts.appUser')

@section('title', 'Crear Incidencia')

@section('content-principal')
<div class="container mt-4">
    <h2>Nueva Incidencia</h2>

    @if ($errors->any())
        <div class="alert alert-danger">
            <strong>Corrige los errores antes de continuar:</strong>
        </div>
    @endif

    <form action="{{ route('incidencias.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="form-group mb-3">
            <label for="titulo">Título</label>
            <input type="text" name="titulo" id="titulo" class="form-control" value="{{ old('titulo') }}" required>
            @error('titulo')
                <div class="text-danger small">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group mb-3">
            <label for="descripcion">Descripción</label>
            <textarea name="descripcion" id="descripcion" class="form-control" rows="5" required>{{ old('descripcion') }}</textarea>
            @error('descripcion')
                <div class="text-danger small">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group mb-3">
            <label for="fecha">Fecha</label>
            <input type="date" name="fecha" id="fecha" class="form-control" value="{{ old('fecha', \Carbon\Carbon::now()->format('Y-m-d')) }}" required>
            @error('fecha')
                <div class="text-danger small">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group mb-3">
            <label for="ruta_imagen">Imagen (opcional)</label>
            <input type="file" name="ruta_imagen" id="ruta_imagen" class="form-control">
            @error('ruta_imagen')
                <div class="text-danger small">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group mb-3">
            <label for="telefono">Teléfono de contacto</label>
            <input type="text" name="telefono" id="telefono" class="form-control"
                   value="{{ old('telefono', $user->telefono) }}" required>
            @error('telefono')
                <div class="text-danger small">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group mb-3">
            <label for="nombre">Nombre de contacto</label>
            <input type="text" name="nombre" id="nombre" class="form-control"
                   value="{{ old('nombre', $user->name . ' ' . $user->surname) }}" required>
            @error('nombre')
                <div class="text-danger small">{{ $message }}</div>
            @enderror
        </div>


        <button type="submit" class="btn btn-primary">Guardar Incidencia</button>
    </form>
</div>
@endsection
