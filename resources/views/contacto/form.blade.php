@extends('layouts.appUser')

@section('title', 'Contacto')

@section('content-principal')
<div class="container mt-4">
    <h4>Datos de Contacto</h4>

    @if ($contacto)
        <p><strong>Empresa:</strong> {{ $contacto->nombre_empresa }}</p>
        <p><strong>CIF:</strong> {{ $contacto->cif }}</p>
        <p><strong>Dirección:</strong> {{ $contacto->domicilio }}, {{ $contacto->ciudad }} ({{ $contacto->provincia }}) {{ $contacto->codigo_postal }}</p>
        <p><strong>Teléfono:</strong> {{ $contacto->telefono }}</p>
        @if($contacto->maps)
            <div class="mt-3">
                {!! $contacto->maps !!}
            </div>
        @endif
    @else
        <p>No hay información de contacto disponible.</p>
    @endif

    <hr>

    <h5>Formulario de contacto</h5>
    <form action="#" method="POST">
        @csrf
        <div class="mb-3">
            <label class="form-label">Nombre</label>
            <input type="text" class="form-control" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Correo electrónico</label>
            <input type="email" class="form-control" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Mensaje</label>
            <textarea class="form-control" rows="4" required></textarea>
        </div>
        <button type="submit" class="btn btn-success">Enviar</button>
    </form>
</div>
@endsection
