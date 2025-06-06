@extends('layouts.appUser')

@section('title', 'Editar Aviso WhatsApp')

@section('content-principal')
<div class="container py-4">
    <h2 class="mb-4">Editar Aviso WhatsApp</h2>

    <form method="POST" action="{{ route('config.avisos-whatsapp.update', $aviso) }}">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="nombre" class="form-label">Nombre</label>
            <input type="text" name="nombre" class="form-control" value="{{ old('nombre', $aviso->nombre) }}" required>
            @error('nombre') <small class="text-danger">{{ $message }}</small> @enderror
        </div>

        <div class="mb-3">
            <label for="numero" class="form-label">Número de Teléfono</label>
            <input type="text" name="numero" class="form-control" value="{{ old('numero', $aviso->numero) }}" required>
            @error('numero') <small class="text-danger">{{ $message }}</small> @enderror
        </div>

        <div class="mb-3">
            <label for="idioma" class="form-label">Idioma (Código WhatsApp)</label>
            <select name="idioma" class="form-select" required>
                <option value="es" {{ $aviso->idioma == 'es' ? 'selected' : '' }}>Español (es)</option>
                <option value="en" {{ $aviso->idioma == 'en' ? 'selected' : '' }}>Inglés (en)</option>
                <option value="fr" {{ $aviso->idioma == 'fr' ? 'selected' : '' }}>Francés (fr)</option>
                <option value="de" {{ $aviso->idioma == 'de' ? 'selected' : '' }}>Alemán (de)</option>
            </select>
            @error('idioma') <small class="text-danger">{{ $message }}</small> @enderror
        </div>

        <button type="submit" class="btn btn-primero rounded-pill px-4">Actualizar</button>
    </form>
</div>
@endsection