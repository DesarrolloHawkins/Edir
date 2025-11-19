@props(['route' => null, 'label' => 'Atrás'])

@php
    $target = $route ?: url()->previous();
@endphp

@if ($target)
    <a href="{{ $target }}"
       class="btn btn-white text-secondary d-inline-flex align-items-center gap-2 rounded-pill px-4 py-2 shadow-sm">
        <i class="fas fa-arrow-left"></i>
        <span>{{ $label }}</span>
    </a>
@else
    <button type="button"
            class="btn btn-white text-secondary d-inline-flex align-items-center gap-2 rounded-pill px-4 py-2 shadow-sm"
            onclick="window.history.back()">
        <i class="fas fa-arrow-left"></i>
        <span>{{ $label }}</span>
    </button>
@endif

