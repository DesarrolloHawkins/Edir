@extends('layouts.appUser')

@section('title', 'Ver Plantilla')
@section('back-url', route('config.whatsapp.templates'))

@section('content-principal')
<div class="container py-4">
    <h4 class="mb-4">Vista previa: {{ $template->name }}</h4>

    <p><strong>Idioma:</strong> {{ $template->language }}</p>
    <p><strong>Categoría:</strong> {{ $template->category }}</p>
    <p><strong>Estado:</strong> {{ $template->status }}</p>

    <div class="mb-4 p-3 border bg-light rounded">
        @php
            $header = collect($template->components)->firstWhere('type', 'HEADER');
            $body = collect($template->components)->firstWhere('type', 'BODY');
            $buttons = collect($template->components)->firstWhere('type', 'BUTTONS')['buttons'] ?? [];
        @endphp
        @if($header)
            <div><strong>{{ $header['text'] }}</strong></div>
        @endif
        <div>{{ $body['text'] ?? '' }}</div>
        @if(!empty($buttons))
            <div class="mt-2">
                @foreach($buttons as $btn)
                    <a href="#" class="btn btn-success btn-sm mt-1">{{ $btn['text'] }}</a>
                @endforeach
            </div>
        @endif
    </div>
    <a href="{{ route('templates.edit', $template) }}" class="btn btn-warning">Editar</a>
    <a href="{{ route('templates.checkStatus', $template) }}" class="btn btn-secondary">Actualizar estado</a>
</div>
@endsection