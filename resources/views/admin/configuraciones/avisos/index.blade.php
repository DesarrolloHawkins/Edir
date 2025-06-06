@extends('layouts.appUser')

@section('title', 'Avisos WhatsApp')

@section('content-principal')
<div>
    <a href="{{  route('config.index') }}" class="btn btn-white text-secondary fs-5 rounded-pill px-4 py-2 mb-1">
        <i class="fas fa-arrow-left"></i>
    </a>
</div>
<div class="container pb-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2 class="mb-0">Avisos WhatsApp</h2>
    </div>
    <a href="{{ route('config.avisos-whatsapp.create') }}" class="btn btn-primero rounded-pill px-4 mb-4 w-100">Crear nuevo</a>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if($avisos->isEmpty())
        <p class="text-center">No hay avisos registrados.</p>
    @else
        <div class="table-responsive">
            <table class="table table-bordered align-middle">
                <thead class="table-light">
                    <tr>
                        <th>Nombre</th>
                        <th>Número</th>
                        {{-- <th>Idioma</th> --}}
                        <th class="text-center">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($avisos as $aviso)
                        <tr>
                            <td>{{ $aviso->nombre }}</td>
                            <td>{{ $aviso->numero }}</td>
                            {{-- <td>{{ strtoupper($aviso->idioma) }}</td> --}}
                            <td class="text-center">
                                <a href="{{ route('config.avisos-whatsapp.edit', $aviso) }}" class="btn btn-warning btn-sm rounded-pill">Editar</a>
                                <form action="{{ route('config.avisos-whatsapp.destroy', $aviso) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm rounded-pill" onclick="return confirm('¿Eliminar este aviso?')">Eliminar</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif
</div>
@endsection