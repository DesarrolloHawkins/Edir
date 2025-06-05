@extends('layouts.appUser')

@section('title', 'Editar Incidencia')

@section('content-principal')
<div class="container mt-4">
    <h2>Editar Incidencia</h2>
    <form action="{{ route('incidencias.update', $incidencia->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="form-group">
            <label>Título</label>
            <input type="text" name="titulo" value="{{ old('titulo', $incidencia->titulo) }}" class="form-control" required>
        </div>

        <div class="form-group">
            <label>Descripción</label>
            <textarea name="descripcion" class="form-control" rows="5">{{ old('descripcion', $incidencia->descripcion) }}</textarea>
        </div>

        <div class="form-group">
            <label>Fecha</label>
            <input type="date" name="fecha" value="{{ old('fecha', $incidencia->fecha->format('Y-m-d')) }}" class="form-control" required>
        </div>

        <div class="form-group">
            <label>Imagen (opcional)</label>
            <input type="file" name="ruta_imagen" class="form-control">
            @if($incidencia->ruta_imagen)
                <img src="{{ asset('storage/'.$incidencia->ruta_imagen) }}" width="150" class="mt-2">
            @endif
        </div>

        <button type="submit" class="btn btn-primary mt-3">Actualizar</button>
    </form>
</div>
@endsection
