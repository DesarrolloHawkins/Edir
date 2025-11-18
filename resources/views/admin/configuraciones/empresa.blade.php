@extends('layouts.appUser')

@section('title', 'Configuración de Empresa')

@section('content-principal')
<div>
    <a href="{{ route('config.index') }}" class="btn btn-white text-secondary fs-5 rounded-pill px-4 py-2 mb-1">
        <i class="fas fa-arrow-left"></i>
    </a>
</div>
<div class="container pb-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2 class="mb-0">Configuración de Empresa</h2>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <form action="{{ route('config.empresa.update') }}" method="POST" enctype="multipart/form-data" class="bg-white p-4 rounded shadow-sm">
        @csrf
        
        <div class="mb-3">
            <label for="nombre" class="form-label">Nombre de la Empresa <span class="text-danger">*</span></label>
            <input type="text" name="nombre" id="nombre" class="form-control" 
                   value="{{ old('nombre', $empresa->nombre ?? '') }}" required>
        </div>

        <div class="mb-3">
            <label for="direccion" class="form-label">Dirección</label>
            <input type="text" name="direccion" id="direccion" class="form-control" 
                   value="{{ old('direccion', $empresa->direccion ?? '') }}">
        </div>

        <div class="row">
            <div class="col-md-6 mb-3">
                <label for="telefono" class="form-label">Teléfono</label>
                <input type="text" name="telefono" id="telefono" class="form-control" 
                       value="{{ old('telefono', $empresa->telefono ?? '') }}">
            </div>
            <div class="col-md-6 mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" name="email" id="email" class="form-control" 
                       value="{{ old('email', $empresa->email ?? '') }}">
            </div>
        </div>

        <div class="row">
            <div class="col-md-6 mb-3">
                <label for="cif" class="form-label">CIF/NIF</label>
                <input type="text" name="cif" id="cif" class="form-control" 
                       value="{{ old('cif', $empresa->cif ?? '') }}">
            </div>
            <div class="col-md-6 mb-3">
                <label for="web" class="form-label">Sitio Web</label>
                <input type="url" name="web" id="web" class="form-control" 
                       value="{{ old('web', $empresa->web ?? '') }}" placeholder="https://ejemplo.com">
            </div>
        </div>

        <div class="mb-3">
            <label for="logo" class="form-label">Logo</label>
            <input type="file" name="logo" id="logo" class="form-control" accept="image/*">
            @if($empresa && $empresa->logo)
                <div class="mt-2">
                    <img src="{{ asset('storage/' . $empresa->logo) }}" alt="Logo actual" 
                         style="max-width: 200px; max-height: 200px;" class="img-thumbnail">
                    <p class="text-muted small mt-2">Logo actual</p>
                </div>
            @endif
        </div>

        <div class="mb-3">
            <label for="descripcion" class="form-label">Descripción</label>
            <textarea name="descripcion" id="descripcion" class="form-control" rows="4">{{ old('descripcion', $empresa->descripcion ?? '') }}</textarea>
            <small class="form-text text-muted">Esta descripción se puede usar en los emails y documentos.</small>
        </div>

        <div class="d-flex gap-2">
            <button type="submit" class="btn btn-primero rounded-pill px-4">Guardar Configuración</button>
            <a href="{{ route('config.index') }}" class="btn btn-secondary rounded-pill px-4">Cancelar</a>
        </div>
    </form>
</div>
@endsection

