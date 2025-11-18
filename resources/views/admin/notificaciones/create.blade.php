@extends('layouts.appUser')

@section('title', 'Crear Notificación')

@section('head')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0/dist/css/select2.min.css" rel="stylesheet" />
@endsection

@section('content-principal')
<div class="container">
    <div class="page-title-box">
        <div class="row align-items-center">
            <div class="col-sm-12 col-md-12">
                <h4 class="page-title">CREAR NOTIFICACION</h4>
            </div>
        </div>
    </div>

    <form action="{{ route('notificaciones.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="mb-3">
            <label for="titulo" class="form-label">Título</label>
            <input type="text" name="titulo" id="titulo" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="tipo" class="form-label">Tipo</label>
            <select name="tipo" id="tipo" class="form-control" required>
                <option value="Informativo">Informativo</option>
                <option value="Urgente">Urgente</option>
                <option value="Otro">Otro</option>
            </select>
        </div>

        <div class="mb-3">
            <label for="datetime" class="form-label">Fecha y Hora</label>
            <input type="datetime-local" name="datetime" id="datetime" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="descripcion" class="form-label">Descripción</label>
            <textarea name="descripcion" id="descripcion" rows="4" class="form-control" required></textarea>
        </div>

        <div class="mb-3">
            <label for="comunidad_id" class="form-label">Comunidad</label>
            <select name="comunidad_id" id="comunidad_id" class="form-control select2">
                <option value="">Todas las comunidades</option>
                @foreach ($comunidades as $comunidad)
                    <option value="{{ $comunidad->id }}">{{ $comunidad->nombre }}</option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label for="metodo_envio" class="form-label">Forma de Envío</label>
            <select name="metodo_envio" id="metodo_envio" class="form-control" required>
                <option value="email" selected>📧 Email (Habilitado)</option>
                <option value="whatsapp" disabled>📱 WhatsApp (No disponible - API pendiente)</option>
            </select>
            <small class="form-text text-muted">WhatsApp estará disponible cuando se configure la API.</small>
        </div>

        <div class="mb-3">
            <label for="ruta_archivo" class="form-label">Archivo (opcional)</label>
            <input type="file" name="ruta_archivo" id="ruta_archivo" class="form-control">
            <small class="form-text text-muted">Si selecciona un archivo, se adjuntará al email.</small>
        </div>

        <button type="submit" class="btn btn-primary">Crear</button>
        <a href="{{ route('notificaciones.index') }}" class="btn btn-secondary">Cancelar</a>
    </form>
</div>
@endsection

@section('scripts')
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0/dist/js/select2.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#comunidad_id').select2({
                placeholder: "Todas las comunidades",
                allowClear: true
            });

            // Prevenir que se seleccione WhatsApp
            $('#metodo_envio').on('change', function() {
                if ($(this).val() === 'whatsapp') {
                    $(this).val('email');
                    alert('WhatsApp no está disponible aún. La API está pendiente de configuración.');
                }
            });
        });
    </script>
@endsection
