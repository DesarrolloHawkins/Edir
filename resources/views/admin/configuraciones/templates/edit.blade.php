@extends('layouts.appUser')

@section('title', 'Editar Plantilla WhatsApp')

@section('content-principal')
<div>
    <a href="{{  route('config.whatsapp.templates') }}" class="btn btn-white text-secondary fs-5 rounded-pill px-4 py-2 mb-1">
        <i class="fas fa-arrow-left"></i>
    </a>
</div>
<div class="container py-4">
    <h4 class="mb-4">Editar plantilla: {{ $template->name }}</h4>

    <form method="POST" action="{{ route('config.whatsapp.templates.update', $template) }}">
        @csrf
        @method('PUT')

        @php
            $header = collect($template->components)->firstWhere('type', 'HEADER');
            $body = collect($template->components)->firstWhere('type', 'BODY');
            $buttons = collect($template->components)->firstWhere('type', 'BUTTONS')['buttons'] ?? [];
        @endphp

        <div class="mb-3">
            <label>Estado</label>
            <input name="status" class="form-control" value="{{ $template->status }}" required>
        </div>

        <div class="mb-3">
            <label>Encabezado</label>
            <input type="text" name="header_text" class="form-control" value="{{ $header['text'] ?? '' }}">
        </div>

        <div class="mb-3">
            <label>Mensaje</label>
            <textarea name="body_text" class="form-control" rows="5" required>{{ $body['text'] ?? '' }}</textarea>
        </div>

        @foreach ($buttons as $i => $btn)
            <div class="mb-3">
                <label>Botón {{ $i + 1 }}</label>
                <div class="input-group">
                    <input type="text" name="buttons[{{ $i }}][text]" class="form-control" value="{{ $btn['text'] }}">
                    <input type="url" name="buttons[{{ $i }}][url]" class="form-control" value="{{ $btn['url'] }}">
                </div>
            </div>
        @endforeach

        <button type="submit" class="btn btn-primero">Guardar y reenviar</button>
    </form>
</div>
@endsection