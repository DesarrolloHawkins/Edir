@extends('layouts.appUser')

@section('title', 'Editar Contacto')

@section('content-principal')
<div class="container">
    <h4 class="my-4">Editar Datos de Contacto</h4>

    <form method="POST" action="{{ route('contacto.update') }}">
        @csrf

        <div class="mb-3">
            <label class="form-label">Nombre Empresa</label>
            <input type="text" name="nombre_empresa" class="form-control" value="{{ old('nombre_empresa', $contacto->nombre_empresa ?? '') }}" required>
        </div>

        <div class="mb-3">
            <label class="form-label">CIF</label>
            <input type="text" name="cif" class="form-control" value="{{ old('cif', $contacto->cif ?? '') }}">
        </div>

        <div class="mb-3">
            <label class="form-label">Domicilio</label>
            <input type="text" name="domicilio" class="form-control" value="{{ old('domicilio', $contacto->domicilio ?? '') }}" required>
        </div>

        <div class="row">
            <div class="col-md-4 mb-3">
                <label class="form-label">Ciudad</label>
                <input type="text" name="ciudad" class="form-control" value="{{ old('ciudad', $contacto->ciudad ?? '') }}" required>
            </div>
            <div class="col-md-4 mb-3">
                <label class="form-label">Provincia</label>
                <input type="text" name="provincia" class="form-control" value="{{ old('provincia', $contacto->provincia ?? '') }}" required>
            </div>
            <div class="col-md-4 mb-3">
                <label class="form-label">Código Postal</label>
                <input type="text" name="codigo_postal" class="form-control" value="{{ old('codigo_postal', $contacto->codigo_postal ?? '') }}" required>
            </div>
        </div>

        <div class="mb-3">
            <label class="form-label">Teléfono</label>
            <input type="text" name="telefono" class="form-control" value="{{ old('telefono', $contacto->telefono ?? '') }}" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Mapa (iframe o enlace)</label>
            <textarea name="maps" class="form-control" rows="3">{{ old('maps', $contacto->maps ?? '') }}</textarea>
        </div>

        <button type="submit" class="btn btn-primary">Guardar</button>
    </form>
</div>
@endsection
