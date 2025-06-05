@extends('layouts.appUser')

@section('title', 'Administrar Usuarios')

@section('content-principal')
<div>
    <div class="container-fluid">
        <div class="page-title-box">
            <div class="row align-items-center">
                <div class="col-sm-6 col-md-12">
                    <h4 class="page-title">USUARIOS</h4>
                </div>
            </div>
        </div>

        <!-- Filtros -->
        <form method="GET" action="{{ route('usuarios.index') }}">
            <div class="row mb-4">
                <div class="col-md-2 mb-2">
                    <select name="per_page" class="form-control" onchange="this.form.submit()">
                        <option value="10" {{ $perPage == 10 ? 'selected' : '' }}>10 por página</option>
                        <option value="25" {{ $perPage == 25 ? 'selected' : '' }}>25 por página</option>
                        <option value="50" {{ $perPage == 50 ? 'selected' : '' }}>50 por página</option>
                    </select>
                </div>

                <div class="col-md-3 mb-2">
                    <select name="comunidad_id" class="form-control" onchange="this.form.submit()">
                        <option value="">Todas las comunidades</option>
                        @foreach ($comunidades as $comunidad)
                            <option value="{{ $comunidad->id }}" {{ $comunidadId == $comunidad->id ? 'selected' : '' }}>
                                {{ $comunidad->nombre }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-4 mb-2">
                    <input type="text" name="search" value="{{ $search }}" class="form-control" placeholder="Buscar..." onchange="this.form.submit()">
                </div>
            </div>
        </form>

        <!-- Tabla -->
        @if (count($usuarios) > 0)
            <table class="table" id="usuariosTable">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Usuario</th>
                        <th>Nombre</th>
                        <th>Email</th>
                        <th>Teléfono</th>
                        <th>Rol</th>
                        <th>Comunidad</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($usuarios as $usuario)
                        <tr>
                            <td>{{ $usuario->id }}</td>
                            <td>{{ $usuario->username }}</td>
                            <td>{{ $usuario->name }} {{ $usuario->surname }}</td>
                            <td>{{ $usuario->email }}</td>
                            <td>{{ $usuario->telefono }}</td>
                            <td>{{ $usuario->role }}</td>
                            <td>{{ $usuario->comunidad->nombre ?? 'Sin comunidad' }}</td>
                            <td>
                                <a href="{{ route('usuarios.edit', $usuario->id) }}" class="btn btn-sm btn-warning">Editar</a>
                                <form action="{{ route('usuarios.destroy', $usuario->id) }}" method="POST" style="display: inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger">Eliminar</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <style>
                .child ul li {
                    margin-bottom: 12px
                }
                .child ul {
                    list-style: none;
                    padding-left: 0
                }
            </style>

            <!-- Paginación -->
            <div class="d-flex justify-content-end">
                {{ $usuarios->appends(request()->query())->links() }}
            </div>
        @else
            <h6 class="text-center">No existen usuarios</h6>
        @endif
    </div>
</div>
@endsection

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
    $(document).ready(function () {
        $('#usuariosTable').DataTable({
            paging: false,
            lengthChange: false,
            searching: false,
            ordering: true,
            responsive: true,
            info: true,
            language: {
                paginate: {
                    next: 'Siguiente',
                    previous: 'Anterior',
                },
                info: 'Mostrando _START_ a _END_ de _TOTAL_ registros',
                zeroRecords: 'No se encontraron registros',
                infoEmpty: 'No hay registros disponibles',
            },
        });
    });
</script>
@endsection
