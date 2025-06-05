@extends('layouts.appUser')

@section('title', 'Detalle de Incidencia')

@section('content-principal')
<div class="container mt-4">
    <h2>{{ $incidencia->titulo }}</h2>
    <p><strong>Fecha:</strong> {{ $incidencia->fecha->format('d/m/Y') }}</p>
    <p><strong>Descripción:</strong><br>{{ $incidencia->descripcion }}</p>

    @if($incidencia->ruta_imagen)
        <div class="mt-3">
            <img src="{{ asset('storage/' . $incidencia->ruta_imagen) }}" width="300" class="img-fluid">
        </div>
    @endif

    <a href="{{ route('incidencias.index') }}" class="btn btn-secondary mt-3">Volver</a>
</div>
@endsection
