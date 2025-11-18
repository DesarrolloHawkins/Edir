@php
    $tipoTexto = is_numeric($alerta->tipo) 
        ? ($alerta->tipo == 1 ? 'Urgente' : 'Informativo')
        : $alerta->tipo;
@endphp

@component('mail::message')
# {{ $alerta->titulo }}

@if($tipoTexto == 'Urgente' || $alerta->tipo == 1)
<div style="background-color: #ff4444; color: white; padding: 10px; border-radius: 5px; margin-bottom: 20px; text-align: center; font-weight: bold;">
    🔴 NOTIFICACIÓN URGENTE
</div>
@elseif($tipoTexto == 'Informativo' || $alerta->tipo == 0)
<div style="background-color: #4CAF50; color: white; padding: 10px; border-radius: 5px; margin-bottom: 20px; text-align: center; font-weight: bold;">
    ℹ️ NOTIFICACIÓN INFORMATIVA
</div>
@else
<div style="background-color: #2196F3; color: white; padding: 10px; border-radius: 5px; margin-bottom: 20px; text-align: center; font-weight: bold;">
    📢 NOTIFICACIÓN - {{ $tipoTexto }}
</div>
@endif

<div style="background-color: #f5f5f5; padding: 20px; border-radius: 8px; margin-bottom: 20px;">
    <p style="color: #333; font-size: 16px; line-height: 1.6; margin: 0;">
        {{ $alerta->descripcion }}
    </p>
</div>

@if($alerta->datetime)
<div style="margin-bottom: 20px;">
    <strong style="color: #666;">📅 Fecha y Hora:</strong>
    <span style="color: #333;">{{ \Carbon\Carbon::parse($alerta->datetime)->format('d/m/Y H:i') }}</span>
</div>
@endif

@if($alerta->comunidad)
<div style="margin-bottom: 20px;">
    <strong style="color: #666;">🏘️ Comunidad:</strong>
    <span style="color: #333;">{{ $alerta->comunidad->nombre }}</span>
</div>
@endif

@if($alerta->url)
@component('mail::button', ['url' => $alerta->url, 'color' => 'primary'])
Ver más detalles
@endcomponent
@endif

@php
    $empresa = \App\Models\EmpresaConfig::first();
@endphp

<div style="margin-top: 30px; padding-top: 20px; border-top: 1px solid #e0e0e0; color: #999; font-size: 12px;">
    <p style="margin: 0;">Este es un mensaje automático del sistema EDIR. Por favor, no responda a este correo.</p>
    @if($empresa)
        @if($empresa->direccion)
            <p style="margin: 5px 0 0 0;">{{ $empresa->direccion }}</p>
        @endif
        @if($empresa->telefono)
            <p style="margin: 5px 0 0 0;">Teléfono: {{ $empresa->telefono }}</p>
        @endif
        @if($empresa->email)
            <p style="margin: 5px 0 0 0;">Email: {{ $empresa->email }}</p>
        @endif
        @if($empresa->web)
            <p style="margin: 5px 0 0 0;">Web: <a href="{{ $empresa->web }}" style="color: #999;">{{ $empresa->web }}</a></p>
        @endif
    @endif
</div>

Gracias,<br>
@if($empresa && $empresa->nombre)
    {{ $empresa->nombre }}
@else
    {{ config('app.name') }}
@endif
@endcomponent
