@extends('layouts.appUser')
@section('title', 'Mantenimiento')
@section('back-url', route('config.index'))
@section('content-principal')
<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h4>Listado de Mantenimiento</h4>
    </div>
    <a href="{{ route('config.mantenimiento.create') }}" class="btn btn-primero rounded-pill px-4 mb-4 w-100">Nuevo</a>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="table-responsive">
        <table class="table table-bordered align-middle text-nowrap">
            <thead class="table-light">
                <tr>
                    <th>Nombre</th>
                    <th>Empresa</th>
                    <th>Número</th>
                    <th>Disponibilidad</th>
                    <th class="text-center">Acciones</th>
                </tr>
            </thead>
            <tbody>
            @forelse($mantenimientos as $m)
                <tr>
                    <td>{{ $m->nombre }}</td>
                    <td>{{ $m->empresa ?? '-' }}</td>
                    <td>{{ $m->numero }}</td>
                    <td>
                        @if($m->disponibilidad)
                            <ul class="list-unstyled mb-0">
                                @foreach($m->disponibilidad as $dia => $horas)
                                    <li><strong>{{ ucfirst($dia) }}:</strong>
                                        <ul class="list-inline">
                                            @foreach($horas as $h)
                                                <li class="list-inline-item">
                                                    {{ $h['inicio'] }} - {{ $h['fin'] }}
                                                </li>
                                            @endforeach
                                        </ul>
                                    </li>
                                @endforeach
                            </ul>
                        @else
                            <span class="text-muted">Sin disponibilidad</span>
                        @endif
                    </td>
                    <td class="text-center">
                        <a href="{{ route('config.mantenimiento.edit', $m) }}" class="btn btn-sm btn-outline-primary me-1">
                            <i class="fa-solid fa-pen-to-square"></i>
                        </a>
                        <form action="{{ route('config.mantenimiento.destroy', $m) }}" method="POST" class="d-inline">
                            @csrf @method('DELETE')
                            <button class="btn btn-sm btn-outline-danger" onclick="return confirm('¿Eliminar?')">
                                <i class="fa-solid fa-trash"></i>
                            </button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" class="text-center text-muted">No hay registros aún.</td>
                </tr>
            @endforelse
            </tbody>
        </table>
    </div>
    
</div>
@endsection
