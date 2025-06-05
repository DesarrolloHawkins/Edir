@extends('layouts.appUser')

@section('title', 'Editar Notificación')

@section('content-principal')
<div class="container">
    <div class="page-title-box">
        <div class="row align-items-center">
            <div class="col-sm-6">
                <h4 class="page-title">EDITAR NOTIFICACION</h4>
            </div>
        </div>
    </div>

    <form action="{{ route('notificaciones.update', $notificacion->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="titulo" class="form-label">Título</label>
            <input type="text" name="titulo" id="titulo" class="form-control" value="{{ $notificacion->titulo }}" required>
        </div>

        <div class="mb-3">
            <label for="tipo" class="form-label">Tipo</label>
            <select name="tipo" id="tipo" class="form-control" required>
                <option value="Informativo" {{ $notificacion->tipo == 'Informativo' ? 'selected' : '' }}>Informativo</option>
                <option value="Urgente" {{ $notificacion->tipo == 'Urgente' ? 'selected' : '' }}>Urgente</option>
                <option value="Otro" {{ $notificacion->tipo == 'Otro' ? 'selected' : '' }}>Otro</option>
            </select>
        </div>

        <div class="mb-3">
            <label for="datetime" class="form-label">Fecha y Hora</label>
            <input type="datetime-local" name="datetime" id="datetime" class="form-control" value="{{ $notificacion->datetime->format('Y-m-d\TH:i') }}" required>
        </div>

        <div class="mb-3">
            <label for="descripcion" class="form-label">Descripción</label>
            <textarea name="descripcion" id="descripcion" rows="4" class="form-control" required>{{ $notificacion->descripcion }}</textarea>
        </div>

        <div class="mb-3">
            <label for="comunidad_id" class="form-label">Comunidad</label>
            <select name="comunidad_id" id="comunidad_id" class="form-control">
                <option value="">General</option>
                @foreach ($comunidades as $comunidad)
                    <option value="{{ $comunidad->id }}" {{ $notificacion->comunidad_id == $comunidad->id ? 'selected' : '' }}>
                        {{ $comunidad->nombre }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label for="ruta_archivo" class="form-label">Archivo (opcional)</label>
            <input type="file" name="ruta_archivo" id="ruta_archivo" class="form-control">
            @if ($notificacion->ruta_archivo)
                <p class="mt-2">
                    Archivo actual: <a href="{{ asset('storage/' . $notificacion->ruta_archivo) }}" target="_blank">Ver archivo</a>
                </p>
            @endif
        </div>

        <button type="submit" class="btn btn-primary">Actualizar</button>
        <a href="{{ route('notificaciones.index') }}" class="btn btn-secondary">Cancelar</a>
    </form>
</div>
@endsection
