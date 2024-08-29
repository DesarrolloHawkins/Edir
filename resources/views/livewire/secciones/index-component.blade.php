<div class="container-fluid">
    <style>
        .dataTables_wrapper .dataTables_filter>label {
            display: block;
            text-align: left;
            font-size: 1rem;
        }

        .dataTables_wrapper .dataTables_filter {
            width: 100%;
            margin-bottom: 1rem;
        }

        #datatable-buttons>tbody>tr.child>td>ul>li>span.dtr-title {
            font-weight: bold !important;
        }
        td{
            padding-top: unset !important;
            padding-bottom: unset !important;

        }
        li.paginate_button{
            font-size: 5px;
        }
    </style>
    <div class="page-title-box">
        <div class="row align-items-center">
            <div class="col-sm-6">
                <h4 class="page-title">ADMINISTRAR SECCIONES</h4>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-right">
                    <li class="breadcrumb-item"><a href="javascript:void(0);">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="javascript:void(0);">Secciones</a></li>
                    <li class="breadcrumb-item active">Administrar secciones</li>
                </ol>
            </div>
        </div> <!-- end row -->
    </div>
    <!-- end page-title -->
    <div class="row">
        <div class="col-12">
            <div class="card m-b-30">
                <div class="card-body">
                    @if (count($secciones) > 0)
                        <table id="datatable-buttons" class="table table-striped table-bordered dt-responsive nowrap"
                            style="border-collapse: collapse; border-spacing: 0; width: 100%;" wire:key='time()'>
                            <thead>
                                <tr>
                                    <th scope="col">Nombre</th>
                                    <th scope="col">Icono @mobile<br>@endmobile</th>
                                    <th scope="col">Sección padre @mobile<br>@endmobile</th>
                                    <th scope="col">Acciones @mobile<br>@endmobile</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($secciones as $seccion)
                                    <tr>
                                        <td>{{ $seccion->nombre }}</td>
                                        <td width="10%"><img src="{{ asset('storage/photos/' . $seccion->ruta_imagen) }}" onerror="this.onerror=null; this.src='{{asset('storage/communitas_icon.png')}}';"
                                            style="max-width: 32px !important; !important; text-align: center"></td>
                                        <td>
                                            @if ($seccion->seccion_padre_id == 0)
                                                Sin sección padre
                                            @else
                                                {{ $secciones->firstWhere('id', $seccion->seccion_padre_id)->nombre }}
                                            @endif
                                        </td>
                                        <td> <a href="secciones-edit/{{ $seccion->id }}"
                                                class="btn btn-primary">Ver/Editar</a> </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @else
                        <h6 class="text-center">No existen secciones para el tablón de anuncios</h6>
                    @endif
                    <a href="javascript:void(0);" class="btn btn-lg btn-primary btn-block" style="font-size: 20px;" onclick="validarComunidad()">Añadir nueva sección</a>

                </div>
            </div>
        </div>
    </div>
</div>


@section('scripts')
    {{-- <script src="https://cdn.datatables.net/responsive/2.4.0/js/dataTables.responsive.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.2/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.3.4/js/dataTables.buttons.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.3.4/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.3.4/js/buttons.print.min.js"></script>
    <script>
        $(document).ready(function() {
            console.log('entro');
            $('#tablePresupuestos').DataTable({
                responsive: true,
                dom: 'Bfrtip',
                buttons: [
                    'copy', 'csv', 'excel', 'pdf', 'print'
                ],
                buttons: [{
                    extend: 'collection',
                    text: 'Export',
                    buttons: [{
                            extend: 'pdf',
                            className: 'btn-export'
                        },
                        {
                            extend: 'excel',
                            className: 'btn-export'
                        }
                    ],
                    className: 'btn btn-info text-white'
                }],
                "language": {
                    "lengthMenu": "Mostrando _MENU_ registros por página",
                    "zeroRecords": "Nothing found - sorry",
                    "info": "Mostrando página _PAGE_ of _PAGES_",
                    "infoEmpty": "No hay registros disponibles",
                    "infoFiltered": "(filtrado de _MAX_ total registros)",
                    "search": "Buscar:",
                    "paginate": {
                        "first": "Primero",
                        "last": "Ultimo",
                        "next": "Siguiente",
                        "previous": "Anterior"
                    },
                    "zeroRecords": "No se encontraron registros coincidentes",
                }
            });

            addEventListener("resize", (event) => {
                location.reload();
            })
        });
    </script> --}}

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
        function validarComunidad() {
            @if(!$comunidad)
                Swal.fire({
                    icon: 'warning',
                    title: 'Comunidad no seleccionada',
                    text: 'No tienes ninguna comunidad seleccionada. Por favor, selecciona una comunidad antes de añadir una nueva sección.',
                    confirmButtonText: 'Entendido'
                });
            @else
                window.location.href = "secciones-create";
            @endif
        }
    </script>
@endsection
