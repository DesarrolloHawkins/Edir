@extends('layouts.appUser')

@section('title', isset($mantenimiento) ? 'Editar Mantenimiento' : 'Nuevo Mantenimiento')

@section('content-principal')
<div class="container py-4">
    <h4 class="mb-4">{{ isset($mantenimiento) ? 'Editar Mantenimiento' : 'Crear Mantenimiento' }}</h4>

    @if ($errors->any())
        <div class="alert alert-danger">
            <strong>Errores:</strong>
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ isset($mantenimiento) ? route('config.mantenimiento.update', $mantenimiento) : route('config.mantenimiento.store') }}" method="POST">
        @csrf
        @if(isset($mantenimiento)) @method('PUT') @endif

        <div class="mb-3">
            <label class="form-label">Nombre</label>
            <input name="nombre" class="form-control" value="{{ old('nombre', $mantenimiento->nombre ?? '') }}" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Empresa</label>
            <input name="empresa" class="form-control" value="{{ old('empresa', $mantenimiento->empresa ?? '') }}">
        </div>

        <div class="mb-3">
            <label class="form-label">Número</label>
            <input name="numero" class="form-control" value="{{ old('numero', $mantenimiento->numero ?? '') }}" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Otros cambios</label>
            <textarea name="otros_cambios" class="form-control" rows="3">{{ old('otros_cambios', $mantenimiento->otros_cambios ?? '') }}</textarea>
        </div>

        <div class="mb-3">
            <label class="form-label">Disponibilidad</label>
            @php
                $dias = ['lunes','martes','miercoles','jueves','viernes','sabado','domingo'];
                $data = old('disponibilidad', $mantenimiento->disponibilidad ?? []);
            @endphp
            <div class="row">
                @foreach($dias as $dia)
                    <div class="col-md-6 mb-3">
                        <div class="form-check mb-1">
                            <input class="form-check-input" type="checkbox" id="check_{{ $dia }}" name="dias[]" value="{{ $dia }}" {{ isset($data[$dia]) ? 'checked' : '' }}>
                            <label class="form-check-label" for="check_{{ $dia }}">{{ ucfirst($dia) }}</label>
                        </div>
                        <div class="d-flex gap-2">
                            <input type="time" name="horas[{{ $dia }}][inicio]" class="form-control" value="{{ $data[$dia][0]['inicio'] ?? '' }}">
                            <input type="time" name="horas[{{ $dia }}][fin]" class="form-control" value="{{ $data[$dia][0]['fin'] ?? '' }}">
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        <button type="submit" class="btn btn-primero">Guardar</button>
        <a href="{{ route('config.mantenimiento.index') }}" class="btn btn-secondary ms-2">Volver</a>
    </form>
</div>
@endsection
