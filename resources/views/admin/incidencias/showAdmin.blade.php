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

                <!-- Información del propietario -->
                @if($incidencia->nombre || $incidencia->telefono)
                <div class="mb-3">
                    <label class="form-label">Información del Propietario</label>
                    <div class="card bg-light">
                        <div class="card-body">
                            @if($incidencia->nombre)
                                <p class="mb-1"><strong>Nombre:</strong> {{ $incidencia->nombre }}</p>
                            @endif
                            @if($incidencia->telefono)
                                <p class="mb-0"><strong>Teléfono:</strong> {{ $incidencia->telefono }}</p>
                            @endif
                        </div>
                    </div>
                </div>
                @endif

                <!-- Imagen/Documento adjunto -->
                @if($incidencia->ruta_imagen)
                <div class="mb-3">
                    <label class="form-label">Imagen/Documento Adjunto</label>
                    <div class="card">
                        <div class="card-body">
                            @php
                                $extension = strtolower(pathinfo($incidencia->ruta_imagen, PATHINFO_EXTENSION));
                                $isImage = in_array($extension, ['jpg', 'jpeg', 'png', 'gif', 'webp']);
                                $isPdf = $extension === 'pdf';
                            @endphp
                            
                            @if($isImage)
                                <img src="{{ asset('storage/' . $incidencia->ruta_imagen) }}" 
                                     alt="Imagen de la incidencia" 
                                     class="img-fluid rounded mb-2" 
                                     style="max-width: 100%; max-height: 500px; object-fit: contain;">
                                <br>
                                <a href="{{ asset('storage/' . $incidencia->ruta_imagen) }}" 
                                   target="_blank" 
                                   class="btn btn-sm btn-primary">
                                    <i class="fa-solid fa-expand"></i> Ver imagen en tamaño completo
                                </a>
                            @elseif($isPdf)
                                <div class="alert alert-info">
                                    <i class="fa-solid fa-file-pdf"></i> Documento PDF adjunto
                                </div>
                                <a href="{{ asset('storage/' . $incidencia->ruta_imagen) }}" 
                                   target="_blank" 
                                   class="btn btn-sm btn-primary">
                                    <i class="fa-solid fa-file-pdf"></i> Abrir PDF
                                </a>
                            @else
                                <div class="alert alert-info">
                                    <i class="fa-solid fa-file"></i> Archivo adjunto
                                </div>
                                <a href="{{ asset('storage/' . $incidencia->ruta_imagen) }}" 
                                   target="_blank" 
                                   class="btn btn-sm btn-primary">
                                    <i class="fa-solid fa-download"></i> Descargar archivo
                                </a>
                            @endif
                        </div>
                    </div>
                </div>
                @endif

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
