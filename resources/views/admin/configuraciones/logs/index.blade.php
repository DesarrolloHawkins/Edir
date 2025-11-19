@extends('layouts.appUser')

@section('title', 'Logs del Sistema')
@section('back-url', route('config.index'))

@section('content-principal')
<div class="container pb-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2 class="mb-0">Logs del Sistema</h2>
    </div>

    <!-- Filtros -->
    <div class="card mb-4">
        <div class="card-body">
            <form method="GET" action="{{ route('config.logs.index') }}" class="row g-3">
                <div class="col-md-3">
                    <label for="action" class="form-label">Acción</label>
                    <select name="action" id="action" class="form-control">
                        <option value="">Todas las acciones</option>
                        @foreach($actions as $action)
                            <option value="{{ $action }}" {{ request('action') == $action ? 'selected' : '' }}>
                                {{ $action }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-3">
                    <label for="user_id" class="form-label">Usuario</label>
                    <select name="user_id" id="user_id" class="form-control">
                        <option value="">Todos los usuarios</option>
                        @foreach($users as $user)
                            <option value="{{ $user->id }}" {{ request('user_id') == $user->id ? 'selected' : '' }}>
                                {{ $user->name }} {{ $user->surname ?? '' }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-2">
                    <label for="fecha_desde" class="form-label">Fecha Desde</label>
                    <input type="date" name="fecha_desde" id="fecha_desde" class="form-control" 
                           value="{{ request('fecha_desde') }}">
                </div>

                <div class="col-md-2">
                    <label for="fecha_hasta" class="form-label">Fecha Hasta</label>
                    <input type="date" name="fecha_hasta" id="fecha_hasta" class="form-control" 
                           value="{{ request('fecha_hasta') }}">
                </div>

                <div class="col-md-2">
                    <label for="search" class="form-label">Búsqueda</label>
                    <input type="text" name="search" id="search" class="form-control" 
                           placeholder="Buscar..." value="{{ request('search') }}">
                </div>

                <div class="col-md-12">
                    <button type="submit" class="btn btn-primero rounded-pill px-4">Filtrar</button>
                    <a href="{{ route('config.logs.index') }}" class="btn btn-secondary rounded-pill px-4">Limpiar</a>
                </div>
            </form>
        </div>
    </div>

    <!-- Tabla de logs -->
    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>Fecha/Hora</th>
                            <th>Acción</th>
                            <th>Usuario</th>
                            <th>Descripción</th>
                            <th>Referencia</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($logs as $log)
                            <tr>
                                <td>
                                    @if($log->date)
                                        {{ \Carbon\Carbon::parse($log->date)->format('d/m/Y H:i:s') }}
                                    @else
                                        {{ $log->created_at->format('d/m/Y H:i:s') }}
                                    @endif
                                </td>
                                <td>
                                    <span class="badge 
                                        @if($log->action == 'Login') bg-success
                                        @elseif($log->action == 'Email Enviado') bg-info
                                        @elseif($log->action == 'Logout') bg-warning
                                        @else bg-secondary
                                        @endif">
                                        {{ $log->action }}
                                    </span>
                                </td>
                                <td>
                                    @if($log->user)
                                        {{ $log->user->name }} {{ $log->user->surname ?? '' }}
                                    @else
                                        <span class="text-muted">Usuario eliminado</span>
                                    @endif
                                </td>
                                <td>{{ $log->description }}</td>
                                <td>
                                    @if($log->reference)
                                        <small class="text-muted">{{ $log->reference }}</small>
                                    @else
                                        <span class="text-muted">-</span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center text-muted">No se encontraron logs</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Paginación -->
            <div class="mt-3">
                {{ $logs->links() }}
            </div>
        </div>
    </div>
</div>
@endsection

