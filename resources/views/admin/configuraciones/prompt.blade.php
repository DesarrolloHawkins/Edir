@extends('layouts.appUser')

@section('title', 'Prompt del Asistente')
@section('back-url', route('config.index'))

@section('content-principal')
<div class="container py-4">
    <h2 class="text-center mb-4">Configurar Prompt del Asistente</h2>

    @if(session('success'))
        <div class="alert alert-success text-center">
            {{ session('success') }}
        </div>
    @endif

    <form action="{{ $prompt ? route('config.prompt.update', $prompt->id) : route('config.prompt.store') }}" method="POST">
        @csrf
        @if($prompt)
            @method('PUT')
        @endif

        <div class="mb-3">
            <label for="prompt" class="form-label fs-5">Prompt:</label>
            <textarea name="prompt" id="prompt" rows="8" class="form-control" required>{{ old('prompt', $prompt->prompt ?? '') }}</textarea>
            @error('prompt')
                <div class="text-danger mt-2">{{ $message }}</div>
            @enderror
        </div>

        <button type="submit" class="btn btn-primero fs-5 rounded-pill px-4 py-2">
            Guardar
        </button>
    </form>

    @if($prompt)
        <hr class="my-5">
        <h4 class="text-center mb-3">Vista previa del contenido</h4>
        <div class="bg-light border rounded p-4" style="max-height: 800px; overflow-y: auto;">
            {!! \Illuminate\Support\Str::markdown($prompt->prompt) !!}
        </div>
    @endif
</div>
@endsection
