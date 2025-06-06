@extends('layouts.appUser')

@section('title', 'Plantillas WhatsApp')

@section('content-principal')
<div>
    <a href="{{  route('config.index') }}" class="btn btn-white text-secondary fs-5 rounded-pill px-4 py-2 mb-1">
        <i class="fas fa-arrow-left"></i>
    </a>
</div>
<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h4>Plantillas de WhatsApp</h4>
        <div class="d-flex gap-1">
            <a href="{{ route('config.whatsapp.templates.sync') }}" class="btn btn-secondary rounded-pill w-100 ">
                <i class="fa fa-sync me-1"></i> Sincronizar
            </a>
        </div>
    </div>
    <a href="{{ route('config.whatsapp.templates.create') }}" class="btn btn-primero rounded-pill px-4 mb-4 w-100">
        <i class="fa fa-plus me-1"></i> Crear
    </a>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @elseif($errors->any())
        <div class="alert alert-danger">{{ $errors->first() }}</div>
    @endif

    <table class="table table-striped">
        <thead>
            <tr>
                <th>Nombre</th>
                <th>Idioma</th>
                <th>Categoría</th>
                <th>Estado</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
        @foreach($templates as $template)
            <tr>
                <td>{{ $template->name }}</td>
                <td>{{ $template->language }}</td>
                <td>{{ $template->category }}</td>
                <td>
                    <span class="badge {{ $template->status === 'APPROVED' ? 'bg-success' : ($template->status === 'REJECTED' ? 'bg-danger' : 'bg-warning text-dark') }}">
                        {{ ucfirst(strtolower($template->status)) }}
                    </span>
                </td>
                <td class="d-flex gap-1">
                    <a href="{{ route('config.whatsapp.templates.show', $template) }}" class="btn btn-sm btn-info">Ver</a>
                    <a href="{{ route('config.whatsapp.templates.edit', $template) }}" class="btn btn-sm btn-secondary">Editar</a>
                    <a href="{{ route('config.whatsapp.templates.checkStatus', $template) }}" class="btn btn-sm btn-dark"
                       onclick="return confirm('Actualizar estado?')">Estado</a>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>
@endsection
