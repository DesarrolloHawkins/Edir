@extends('layouts.appUser')

@section('title', 'Crear Aviso WhatsApp')

@section('content-principal')
<div class="container py-4">
    <h2 class="mb-4">Nuevo Aviso WhatsApp</h2>

    <form method="POST" action="{{ route('config.avisos-whatsapp.store') }}">
        @csrf

        <div class="mb-3">
            <label for="nombre" class="form-label">Nombre</label>
            <input type="text" name="nombre" class="form-control" value="{{ old('nombre') }}" required>
            @error('nombre') <small class="text-danger">{{ $message }}</small> @enderror
        </div>

        <div class="mb-3">
            <label for="numero" class="form-label">Número de Teléfono</label>
            <input type="text" name="numero" class="form-control" value="{{ old('numero') }}" required>
            @error('numero') <small class="text-danger">{{ $message }}</small> @enderror
        </div>

        <div class="mb-3">
            <label for="idioma" class="form-label">Idioma (Código WhatsApp)</label>
            <select name="idioma" class="form-select" required>
                <option value="es" {{ old('idioma') == 'es' ? 'selected' : '' }}>Español (es)</option>
                <option value="en" {{ old('idioma') == 'en' ? 'selected' : '' }}>Inglés (en)</option>
                <option value="fr" {{ old('idioma') == 'fr' ? 'selected' : '' }}>Francés (fr)</option>
                <option value="de" {{ old('idioma') == 'de' ? 'selected' : '' }}>Alemán (de)</option>
                <!-- Agrega más idiomas si es necesario -->
            </select>
            @error('idioma') <small class="text-danger">{{ $message }}</small> @enderror
        </div>

        <button type="submit" class="btn btn-primero rounded-pill px-4">Guardar</button>
    </form>
</div>
@endsection