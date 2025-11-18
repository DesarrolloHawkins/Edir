@foreach ($secciones as $seccionData)
    @php
        $seccion = $seccionData['seccion'];
        $hijas = $seccionData['hijas'] ?? [];
        $indentacion = $nivel * 30;
    @endphp
    <div class="seccion" data-id="{{ $seccion->id }}" style="margin-left: {{ $indentacion }}px;">
        <div class="seccion-title">
            📂 {{ $seccion->nombre }}
        </div>
        <div class="documentos-container" id="documentos-{{ $seccion->id }}"></div>
    </div>
    @if (count($hijas) > 0)
        @include('administrar.documentos.partials.secciones-tree', ['secciones' => $hijas, 'nivel' => $nivel + 1])
    @endif
@endforeach

