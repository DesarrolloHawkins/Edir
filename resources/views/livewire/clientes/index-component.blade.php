
    <div class="container-fluid">
        <div class="page-title-box">
            <div class="row align-items-center">
                <div class="col-sm-6">
                    <h4 class="page-title">CLIENTES</h4>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-right">
                        <li class="breadcrumb-item"><a href="javascript:void(0);">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="javascript:void(0);">Clientes</a></li>
                        <li class="breadcrumb-item active">Todos los clientes</li>
                    </ol>
                </div>
            </div> <!-- end row -->
        </div>
        <!-- end page-title -->

        <div class="row">
            <div class="col-12">
                <div class="card m-b-30">
                    <div class="card-body">

                        <h4 class="mt-0 header-title">Listado de todos los clientes</h4>
                        <p class="sub-title../plugins">Listado completo de todos nuestros clientes, para editar o ver la informacion completa pulse el boton de Editar en la columna acciones.
                        </p>

                        @if (count($clientes) > 0)
                            <table id="datatable-buttons" class="table table-striped table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                <thead>
                                    <tr>
                                        {{-- <th scope="col">Trato</th> --}}
                                        <th scope="col">Nombre</th>
                                        <th scope="col">Apellidos</th>
                                        {{-- <th scope="col">Tipo de calle</th>
                                        <th scope="col">Calle</th>
                                        <th scope="col">Número</th>
                                        <th scope="col">Dirección Adicional 1</th>
                                        <th scope="col">Dirección Adicional 2</th>
                                        <th scope="col">Dirección Adicional 3</th> --}}
                                        {{-- <th scope="col">Código Postal</th> --}}
                                        {{-- <th scope="col">Ciudad</th> --}}
                                        <th scope="col">NIF/DNI</th>
                                        <th scope="col">Teléfono</th>
                                        {{-- <th scope="col">Teléfono secundario</th>
                                        <th scope="col">Teléfono adcional</th> --}}
                                        <th scope="col">Email</th>
                                        {{-- <th scope="col">Email secundario</th>
                                        <th scope="col">Email adicional</th> --}}
                                        {{-- <th scope="col">Conf Email</th>
                                        <th scope="col">Conf Postal</th>
                                        <th scope="col">Conf SMS</th> --}}
                
                
                
                                        <th scope="col">Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($clientes as $cliente)
                                        <tr>
                                            {{-- <td>{{ $cliente->trato }}</td> --}}
                                            @if($cliente->tipo_cliente != 1)
                                            <td>{{ $cliente->nombre }}</td>
                                            <td>{{ $cliente->apellido }}</td>
                                            @else
                                            <td colspan="2">{{ $cliente->nombre }}</td>
                                            @endif
                                            {{-- <td>{{ $cliente->tipoCalle}}</td>
                                            <td>{{ $cliente->calle }}</td>
                                            <td>{{ $cliente->numero }}</td>
                                            <td>{{ $cliente->direccionAdicional1 }}</td>
                                            <td>{{ $cliente->direccionAdicional2 }}</td>
                                            <td>{{ $cliente->direccionAdicional3 }}</td> --}}
                                            {{-- <td>{{ $cliente->codigoPostal }}</td>
                                            <td>{{ $cliente->ciudad }}</td> --}}
                                            <td>{{ $cliente->nif }}</td>
                                            <td>{{ $cliente->tlf1 }}</td>
                                            {{-- <td>{{ $cliente->tlf2 }}</td>
                                            <td>{{ $cliente->tlf3 }}</td> --}}
                                            <td>{{ $cliente->email1 }}</td>
                                            {{-- <td>{{ $cliente->email2 }}</td>
                                            <td>{{ $cliente->email3 }}</td> --}}
                                            {{-- <td>{{ $cliente->confPostal == 0 ? "No" : "Si"  }}</td>
                                            <td>{{ $cliente->confEmail == 0 ? "No" : "Si"  }}</td>
                                            <td>{{ $cliente->confSms == 0 ? "No" : "Si" }}</td> --}}
                
                
                                            <td> <a href="clientes-edit/{{ $cliente->id }}" class="btn btn-primary">Ver/Editar</a> </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        @endif
                

                    </div>
                </div>
            </div> <!-- end col -->
        </div> <!-- end row -->    
    </div>
    

    @section('scripts')

    <!-- Required datatable js -->
    {{-- <script src="../assets/js/jquery.min.js"></script> --}}
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

    {{-- 

        <script src="https://cdn.datatables.net/responsive/2.4.0/js/dataTables.responsive.min.js"></script>
        <script src="https://cdn.datatables.net/1.13.2/js/jquery.dataTables.min.js"></script>
        <script src="https://cdn.datatables.net/buttons/2.3.4/js/dataTables.buttons.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
        <script src="https://cdn.datatables.net/buttons/2.3.4/js/buttons.html5.min.js"></script>
        <script src="https://cdn.datatables.net/buttons/2.3.4/js/buttons.print.min.js"></script> --}}
        {{-- <script>
            $(document).ready(function() {
                console.log('entro');
                $('#datatable-buttons').DataTable({
                    responsive: true,
                    dom: 'Bfrtip',
                    // buttons: [
                    //     'csv', 'excel', 'pdf', 'print'
                    //     // 'copy', 'csv', 'excel', 'pdf', 'print'
                    // ],
                    buttons: [{
                        extend: 'collection',
                        text: 'Export',
                        buttons: [{
                                extend: 'pdf',
                                className: 'btn btn-secondary buttons-copy buttons-html5'
                            },
                            {
                                extend: 'excel',
                                className: 'btn btn-secondary buttons-copy buttons-html5'
                            }
                        ],
                        className: 'btn-group'
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
    @endsection
