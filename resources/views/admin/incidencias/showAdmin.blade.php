@extends('layouts.appUser')

@section('title', 'Resolver Incidencia')

@section('content-principal')
<div class="container-fluid">
    <div class="page-title-box mt-3">
        <div class="row align-items-center">
            <div class="col-sm-6 col-md-12">
                <h4 class="page-title">RESOLVER INCIDENCIA</h4>
            </div>
        </div>
    </div>
    <div class="card">
        <div class="card-body">
            <form action="{{ route('incidenciasAdmin.updateAdmin', $incidencia->id) }}" method="POST">
                @csrf
                @method('PUT')

                <!-- Detalles de la Incidencia -->
                <div class="mb-3">
                    <label for="titulo" class="form-label">Título</label>
                    <input type="text" id="titulo" name="titulo" class="form-control" value="{{ $incidencia->titulo }}" required>
                </div>

                <div class="mb-3">
                    <label for="descripcion" class="form-label">Descripción</label>
                    <textarea id="descripcion" name="descripcion" class="form-control" rows="5" required>{{ $incidencia->descripcion }}</textarea>
                </div>

                <!-- Estado de la Incidencia -->
                <div class="mb-3">
                    <label for="estado_id" class="form-label">Estado</label>
                    <select id="estado_id" name="estado_id" class="form-select" required>
                        @foreach ($estados as $estado)
                            <option value="{{ $estado->id }}" {{ $incidencia->estado_id == $estado->id ? 'selected' : '' }}>
                                {{ $estado->nombre }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Fecha -->
                <div class="mb-3">
                    <label for="fecha" class="form-label">Fecha</label>
                    <input type="date" id="fecha" name="fecha" class="form-control" value="{{ $incidencia->fecha }}" required>
                </div>

                <!-- Botones de acción -->
                <div class="text-end">
                    <button type="submit" class="btn btn-success">Guardar Cambios</button>
                    <a href="{{ route('incidenciasAdmin.index') }}" class="btn btn-secondary">Cancelar</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
