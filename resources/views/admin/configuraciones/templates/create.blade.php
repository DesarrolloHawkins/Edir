@extends('layouts.appUser')

@section('title', 'Crear Plantilla WhatsApp')

@section('content-principal')
<div>
    <a href="{{  route('config.whatsapp.templates') }}" class="btn btn-white text-secondary fs-5 rounded-pill px-4 py-2 mb-1">
        <i class="fas fa-arrow-left"></i>
    </a>
</div>
<div class="container py-4">
    <h4 class="mb-4">Crear nueva plantilla</h4>

    @if ($errors->any())
        <div class="alert alert-danger">{{ $errors->first() }}</div>
    @endif

    <form method="POST" action="{{ route('config.whatsapp.templates.store') }}">
        @csrf
        <div class="mb-3">
            <label>Nombre</label>
            <input type="text" name="name" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>Idioma</label>
            <input type="text" name="language" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>Categoría</label>
            <select name="category" class="form-control" required>
                <option value="MARKETING">Marketing</option>
                <option value="UTILITY">Utility</option>
                <option value="AUTHENTICATION">Authentication</option>
            </select>
        </div>
        <div class="mb-3">
            <label>Componentes (JSON)</label>
            <textarea name="components" class="form-control" rows="8" required>[{"type": "BODY", "text": "..."}]</textarea>
        </div>
        <button type="submit" class="btn btn-primero">Enviar</button>
    </form>
</div>
@endsection