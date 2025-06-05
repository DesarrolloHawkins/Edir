@extends('layouts.appUser')

@section('title', 'Administrar Notificaciones')

@section('content-principal')
<div class="container">
    <div class="page-title-box">
        <div class="row align-items-center">
            <div class="col-sm-6">
                <h4 class="page-title">NOTIFICACIONES</h4>
            </div>
            <div class="col-sm-6 text-end">
                <a href="{{ route('notificaciones.create') }}" class="btn btn-primary">Crear Notificación</a>
            </div>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <!-- Filtros -->
    <form method="GET" action="{{ route('notificaciones.index') }}">
        <div class="row mb-4">
            <div class="col-md-2">
                <select name="per_page" class="form-control" onchange="this.form.submit()">
                    <option value="10" {{ $perPage == 10 ? 'selected' : '' }}>10 por página</option>
                    <option value="25" {{ $perPage == 25 ? 'selected' : '' }}>25 por página</option>
                    <option value="50" {{ $perPage == 50 ? 'selected' : '' }}>50 por página</option>
                </select>
            </div>
            <div class="col-md-3">
                <select name="comunidad_id" class="form-control" onchange="this.form.submit()">
                    <option value="">Todas las comunidades</option>
                    @foreach ($comunidades as $comunidad)
                        <option value="{{ $comunidad->id }}" {{ $comunidadId == $comunidad->id ? 'selected' : '' }}>
                            {{ $comunidad->nombre }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-4">
                <input type="text" name="search" value="{{ $search }}" class="form-control" placeholder="Buscar..." onchange="this.form.submit()">
            </div>
        </div>
    </form>

    <!-- Tabla -->
    <table class="table" id="notificacionesTable">
        <thead>
            <tr>
                <th>ID</th>
                <th>Título</th>
                <th>Tipo</th>
                <th>Fecha</th>
                <th>Comunidad</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($notificaciones as $notificacion)
                <tr>
                    <td>{{ $notificacion->id }}</td>
                    <td>{{ $notificacion->titulo }}</td>
                    <td>{{ $notificacion->tipo }}</td>
                    <td>{{ $notificacion->datetime }}</td>
                    <td>{{ $notificacion->comunidad->nombre ?? 'General' }}</td>
                    <td>
                        <a href="{{ route('notificaciones.edit', $notificacion->id) }}" class="btn btn-sm btn-warning">Editar</a>
                        <form action="{{ route('notificaciones.destroy', $notificacion->id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger">Eliminar</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="d-flex justify-content-end">
        {{ $notificaciones->links() }}
    </div>
</div>

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

        <script src="../assets/js/jquery.slimscroll.js"></script>

        <script src="../plugins/datatables/jquery.dataTables.min.js"></script>
        <script src="../plugins/datatables/dataTables.bootstrap4.min.js"></script>
        <!-- Buttons examples -->
        <script src="../plugins/datatables/dataTables.buttons.min.js"></script>
        <script src="../plugins/datatables/buttons.bootstrap4.min.js"></script>
        <script src="../plugins/datatables/jszip.min.js"></script>
        <script src="../plugins/datatables/pdfmake.min.js"></script>
        <script src="../plugins/datatables/vfs_fonts.js"></script>
        <script src="../plugins/datatables/buttons.html5.min.js"></script>
        <script src="../plugins/datatables/buttons.print.min.js"></script>
        <script src="../plugins/datatables/buttons.colVis.min.js"></script>
        <!-- Responsive examples -->
        <script src="../plugins/datatables/dataTables.responsive.min.js"></script>
        <script src="../plugins/datatables/responsive.bootstrap4.min.js"></script>
        <script src="../assets/pages/datatables.init.js"></script>
<script>
    $(document).ready(function() {
        $('#notificacionesTable').DataTable({
            "paging": false,
            "searching": false,
            "info": false,
        });
    });
</script>
@endsection
@endsection
