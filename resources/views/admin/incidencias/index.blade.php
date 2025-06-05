@extends('layouts.appUser')

@section('title', 'Administrar secciones')

@section('head')
    {{-- @vite(['resources/sass/productos.scss'])
    @vite(['resources/sass/alumnos.scss']) --}}

@section('content-principal')
<div>
    {{-- @livewire('secciones.index-component') --}}
    <div class="container-fluid">
        <div class="page-title-box">
            <div class="row align-items-center">
                <div class="col-sm-12 col-md-12">
                    <h4 class="page-title">AVISOS</h4>
                </div>
            </div>
        </div>

        <!-- Filtros -->
        <form method="GET" action="{{ route('incidenciasAdmin.index') }}">
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

                <div class="col-md-3 mb-2">
                    <select name="estado_id" class="form-control" onchange="this.form.submit()">
                        <option value="">Todos los estados</option>
                        @foreach ($estados as $estado)
                            <option value="{{ $estado->id }}" {{ $estadoId == $estado->id ? 'selected' : '' }}>
                                {{ $estado->nombre }}
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
        @if (count($incidencias) > 0)
            <table class="table" id="incidenciasTable">
                <thead>
                    <tr>
                        <th class="sortable">ID</th>
                        <th class="sortable">Comunidad</th>
                        <th class="sortable">Concepto</th>
                        <th class="sortable">Estado</th>
                        <th class="sortable">Fecha</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($incidencias as $incidencia)
                        @php
                            $rowClass = '';
                            switch ($incidencia->estado_id) {
                                case 1: $rowClass = 'bg-warning text-dark'; break;
                                case 2: $rowClass = 'bg-info'; break;
                                case 3: $rowClass = 'bg-success'; break;
                                case 4: $rowClass = 'bg-danger'; break;
                                case 5: $rowClass = 'bg-dark'; break;
                                default: $rowClass = 'bg-light text-dark'; break;
                            }
                        @endphp
                        <tr>
                            <td>{{ $incidencia->id }}</td>
                            <td>{{ $incidencia->comunidad->nombre }}</td>
                            <td>{{ $incidencia->titulo }}</td>

                            <td>
                                @if (!$incidencia->estado_id)
                                    <span class="badge bg-secondary text-white px-3 py-1 fs-6">Sin estado</span>
                                @else
                                    @php
                                        $badgeClass = '';
                                        switch ($incidencia->estado_id) {
                                            case 1: $badgeClass = 'badge bg-warning text-dark'; break; // Pendiente
                                            case 2: $badgeClass = 'badge bg-primary'; break; // Procesando
                                            case 3: $badgeClass = 'badge bg-success'; break; // Finalizada
                                            case 4: $badgeClass = 'badge bg-danger'; break; // No procede
                                            case 5: $badgeClass = 'badge bg-dark'; break; // Cancelada
                                            default: $badgeClass = 'badge bg-secondary'; break; // Default
                                        }
                                    @endphp
                                    <span class="{{ $badgeClass }} px-3 py-1 fs-6">{{ $incidencia->estado->nombre }}</span>
                                @endif
                            </td>

                            <td>{{ $incidencia->fecha }}</td>
                            <td><a class="btn btn-primero" href="{{route('incidenciasAdmin.show',$incidencia->id )}}">Ver/Resolver</a></td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <style>
                .child ul li{
                    margin-bottom: 12px
                }
                .child ul{
                    list-style: none;
                    padding-left: 0
                }
            </style>

            <!-- Paginación -->
            <div class="d-flex justify-content-end">
                {{ $incidencias->appends(request()->query())->links() }}
            </div>
        @else
            <h6 class="text-center">No existen avisos</h6>
        @endif
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
                $('#incidenciasTable').DataTable({
                    "paging": true, // Activar la paginación
                    "lengthChange": false, // Desactivar cambio del número de filas por página
                    "searching": false, // Desactivar el buscador por defecto
                    "ordering": true, // Habilitar ordenación
                    "responsive": true, // Habilitar ordenación
                    "info": true, // Mostrar información de la tabla
                    "autoWidth": false, // Desactivar ajuste automático de ancho
                    "language": {
                        "paginate": {
                            "next": "Siguiente",
                            "previous": "Anterior"
                        },
                        "info": "Mostrando _START_ a _END_ de _TOTAL_ registros",
                        "zeroRecords": "No se encontraron registros",
                        "infoEmpty": "No hay registros disponibles",
                    },
                    "columnDefs": [
                        { "orderable": true, "targets": [0, 1, 2, 3, 4] }, // Habilitar ordenación en columnas específicas
                        { "orderable": false, "targets": [5] } // Desactivar ordenación en la columna de acciones
                    ]
                });
            });
        </script>

    @endsection

</div>
@endsection


