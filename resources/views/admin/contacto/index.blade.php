@extends('layouts.appUser')

@section('title', 'Datos de Contacto')

@section('content-principal')
<div class="container py-4">
    <h4 class="mb-4 text-center">Modificar datos de contacto</h4>

    @if(session('success'))
        <div class="alert alert-success text-center">{{ session('success') }}</div>
    @endif

    <form action="{{ route('contacto.update') }}" method="POST">
        @csrf

        <div class="row">
            <div class="col-md-6 mb-3">
                <label>Nombre Empresa</label>
                <input type="text" name="nombre_empresa" class="form-control" value="{{ $contacto->nombre_empresa ?? '' }}">
            </div>
            <div class="col-md-6 mb-3">
                <label>CIF</label>
                <input type="text" name="cif" class="form-control" value="{{ $contacto->cif ?? '' }}">
            </div>
            <div class="col-md-12 mb-3">
                <label>Domicilio</label>
                <input type="text" name="domicilio" class="form-control" value="{{ $contacto->domicilio ?? '' }}">
            </div>
            <div class="col-md-4 mb-3">
                <label>Ciudad</label>
                <input type="text" name="ciudad" class="form-control" value="{{ $contacto->ciudad ?? '' }}">
            </div>
            <div class="col-md-4 mb-3">
                <label>Provincia</label>
                <input type="text" name="provincia" class="form-control" value="{{ $contacto->provincia ?? '' }}">
            </div>
            <div class="col-md-4 mb-3">
                <label>Código Postal</label>
                <input type="text" name="codigo_postal" class="form-control" value="{{ $contacto->codigo_postal ?? '' }}">
            </div>
            <div class="col-md-6 mb-3">
                <label>Teléfono</label>
                <input type="text" name="telefono" class="form-control" value="{{ $contacto->telefono ?? '' }}">
            </div>
            <div class="col-md-6 mb-3">
                <label>Mapa (iframe o URL)</label>
                <input type="text" name="maps" class="form-control" value="{{ $contacto->maps ?? '' }}">
            </div>
        </div>

        <div class="text-center mt-4">
            <button type="submit" class="btn btn-primary px-4">Guardar</button>
        </div>
    </form>
</div>
@endsection
