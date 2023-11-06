<div class="container-fluid">
    <script src="//unpkg.com/alpinejs" defer></script>
    <div class="page-title-box">
        <div class="row align-items-center">
            <div class="col-sm-6">
                <h4 class="page-title">AÑADIR SOCIO</span></h4>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-right">
                    <li class="breadcrumb-item"><a href="javascript:void(0);">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="javascript:void(0);">Socios</a></li>
                    <li class="breadcrumb-item active">Crear socio/transeúnte</li>
                </ol>
            </div>
        </div> <!-- end row -->
    </div>
    <style>
        th,
        td {
            border: 1px solid black !important;
            padding: 5px 5px 5px 5px !important;
        }
    </style>
    <div class="row">
        <div class="col-md-9">
            <div class="card m-b-30">
                <div class="card-body">
                    <table class="table table-bordered dt-responsive nowrap" style="table-layout: fixed !important; width: 100% !important;">
                        <thead>
                            <tr>
                                <th colspan="12">
                                    <h4 style="text-align: center !important">Datos del socio/transeúnte</h4>
                                </th>
                            </tr>
                            <tr>
                                <th colspan="12" rowspan="4">
                                    <h5>Subir foto del barco</h5>
                                    @if ($ruta_foto)
                                        <div class="mb-3 row d-flex justify-content-center">
                                            <div class="col">
                                                <img src="{{ $ruta_foto->temporaryUrl() }}"
                                                    style="max-width: 50% !important; text-align: center">
                                            </div>
                                        </div>
                                    @endif
                                    <div class="mb-3 row d-flex align-items-center">
                                        <div class="col-sm-12">
                                            <input type="file" class="form-control" wire:model="ruta_foto"
                                                name="ruta_foto" id="ruta_foto" placeholder="Imagen del producto...">
                                            @error('nombre')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                </th>
                            </tr>
                        </thead>
                        <tr>
                            <td colspan="6" wire:click="cambiarSituacionBarco(0)"
                                @if ($situacion_barco == 0) style="background-color: #a2b7cf !important" @endif>
                                <h6 style="text-align: center !important">Barco en atraque</h6>
                            </td>
                            <td colspan="6" wire:click="cambiarSituacionBarco(1)"
                                @if ($situacion_barco == 1) style="background-color: #a2b7cf !important" @endif>
                                <h6 style="text-align: center !important">Barco en varada</h6>
                            </td>
                        </tr>
                        @mobile
                        <tr>
                            <td colspan="6" wire:click="cambiarSituacionPersona(0)"
                                @if ($situacion_persona == 0) style="background-color: #a2b7cf !important" @endif>
                                <h6 style="text-align: center !important">Socio</h6>
                            </td>
                            <td colspan="6" wire:click="cambiarSituacionPersona(1)"
                                @if ($situacion_persona == 1) style="background-color: #a2b7cf !important" @endif>
                                <h6 style="text-align: center !important">Transeúnte</h6>
                            </td>
                        </tr>
                        @endmobile
                        @mobile
                        <tr>
                            <th colspan="4">Nombre:</th>
                            <td colspan="8"><input type="text" wire:model="nombre_socio" class="form-control"
                                    name="nombre_socio" placeholder="Nombre"></td>
                        </tr>
                        <tr>
                            <th colspan="4">Nº de socio</th>
                            <td colspan="8"><input type="number" wire:model="numero_socio" class="form-control"
                                    name="numero_socio" placeholder="Número de socio">
                            </td>
                        </tr>
                        @elsemobile
                        <tr>
                            <th colspan="3">Nombre:</th>
                            <td colspan="3"><input type="text" wire:model="nombre_socio" class="form-control"
                                    name="nombre_socio" placeholder="Nombre"></td>
                            <th colspan="3">Nº de socio</th>
                            <td colspan="3"><input type="number" wire:model="numero_socio" class="form-control"
                                    name="numero_socio" placeholder="Número de socio">
                            </td>
                        </tr>
                        @endmobile
                        <tr>
                            <th colspan="4">DNI:</th>
                            <td colspan="8"><input type="text" wire:model="dni" class="form-control"
                                    name="dni" placeholder="DNI"></td>
                        </tr>
                        <tr>
                            <th colspan="4">Dirección:</th>
                            <td colspan="8"><input type="text" wire:model="direccion" class="form-control"
                                    name="direccion" placeholder="Dirección"></td>
                        </tr>
                        <tr>
                            <th colspan="4">Teléfono 1:</th>
                            <td colspan="8"><input type="text" wire:model="telefono_1" class="form-control"
                                    name="telefono_1" placeholder="Teléfono 1"></td>
                        </tr>
                        <tr>
                            <th colspan="4">Teléfono 2:</th>
                            <td colspan="8"><input type="text" wire:model="telefono_2" class="form-control"
                                    name="telefono_2" placeholder="Teléfono 2"></td>
                        </tr>
                        <tr>
                            <th colspan="4">Teléfono 3:</th>
                            <td colspan="8"><input type="text" wire:model="telefono_3" class="form-control"
                                    name="telefono_3" placeholder="Teléfono 3"></td>
                        </tr>
                        <tr>
                            <th colspan="4">Email:</th>
                            <td colspan="8"><input type="text" wire:model="email" class="form-control"
                                    name="email" placeholder="Email"></td>
                        </tr>
                        <tr>
                            <th colspan="4">Pantalán T Atraque:</th>
                            <td colspan="8"><input type="text" wire:model="pantalan_t_atraque"
                                    class="form-control" name="pantalan_t_atraque" placeholder="Pantalán T Atraque">
                            </td>
                        </tr>
                        <tr>
                            <th colspan="4">Nombre del barco:</th>
                            <td colspan="8"><input type="text" wire:model="nombre_barco" class="form-control"
                                    name="nombre_barco" placeholder="Nombre del barco"></td>
                        </tr>
                        <tr>
                            <th colspan="4">Matrícula:</th>
                            <td colspan="8"><input type="text" wire:model="matricula" class="form-control"
                                    name="matricula" placeholder="Matrícula"></td>
                        </tr>
                        @mobile
                        <tr>
                            <th colspan="4">Eslora:</th>
                            <td colspan="8"><input type="text" wire:model="eslora" class="form-control"
                                    name="eslora" placeholder="Eslora"></td>
                        </tr>
                        <tr>
                            <th colspan="4">Manga:</th>
                            <td colspan="8"><input type="text" wire:model="manga" class="form-control"
                                    name="manga" placeholder="Manga"></td>
                        </tr>
                        <tr>
                            <th colspan="4">Calado:</th>
                            <td colspan="8"><input type="text" wire:model="calado" class="form-control"
                                    name="calado" placeholder="Calado"></td>
                        </tr>
                        @elsemobile
                        <tr>
                            <th colspan="2">Eslora:</th>
                            <td colspan="2"><input type="text" wire:model="eslora" class="form-control"
                                    name="eslora" placeholder="Eslora"></td>
                            <th colspan="2">Manga:</th>
                            <td colspan="2"><input type="text" wire:model="manga" class="form-control"
                                    name="manga" placeholder="Manga"></td>
                            <th colspan="2">Calado:</th>
                            <td colspan="2"><input type="text" wire:model="calado" class="form-control"
                                    name="calado" placeholder="Calado"></td>
                        </tr>
                        @endmobile()
                        <tr>
                            <th colspan="4">Nº de llave:</th>
                            <td colspan="8"><input type="text" wire:model="numero_llave" class="form-control"
                                    name="numero_llave" placeholder="Nº de llave"></td>
                        </tr>
                        @mobile
                            <tr>
                                <th colspan="4">Seguro barco:</th>
                                <td colspan="8"><input type="text" wire:model="seguro_barco" class="form-control"
                                        name="seguro_barco" placeholder="Seguro barco"></td>
                            </tr>
                            <tr>
                                <th colspan="4">Póliza:</th>
                                <td colspan="8"><input type="text" wire:model="poliza" class="form-control"
                                        name="poliza" placeholder="Póliza"></td>
                            </tr>
                            <tr>
                                <th colspan="4">Vencimiento:</th>
                                <td colspan="8"><input type="text" wire:model="vencimiento" class="form-control"
                                        name="vencimiento" placeholder="Vencimiento"></td>
                            </tr>
                        @elsemobile
                            <tr>
                                <th colspan="2">Seguro barco:</th>
                                <td colspan="2"><input type="text" wire:model="seguro_barco" class="form-control"
                                        name="seguro_barco" placeholder="Seguro barco"></td>
                                <th colspan="2">Póliza:</th>
                                <td colspan="2"><input type="text" wire:model="poliza" class="form-control"
                                        name="poliza" placeholder="Póliza"></td>
                                <th colspan="2">Vencimiento:</th>
                                <td colspan="2"><input type="text" wire:model="vencimiento" class="form-control"
                                        name="vencimiento" placeholder="Vencimiento"></td>
                            </tr>
                        @endmobile
                        <tr>
                            <th colspan="4">ITB:</th>
                            <td colspan="8"><input type="text" wire:model="itb" class="form-control"
                                    name="itb" placeholder="ITB"></td>
                        </tr>
                    </table>
                </div>
            </div>

        </div>
        <div class="col-md-3 justify-content-center">
            @notmobile
            <div class="position-fixed">
                <div class="card m-b-30">
                    <div class="card-body">
                        <h5>Situación de persona</h5>
                        <div class="row">
                            <div class="col-12">
                                <table class="table table-bordered dt-responsive nowrap">
                                    <tr>
                                        <td wire:click="cambiarSituacionPersona(0)"
                                        @if ($situacion_persona == 0) style="background-color: #a2b7cf !important" @endif>
                                        <h6 style="text-align: center !important">Socio</h6></td>
                                    </tr>
                                    <tr>
                                        <td wire:click="cambiarSituacionPersona(1)"
                                        @if ($situacion_persona == 1) style="background-color: #a2b7cf !important" @endif>
                                        <h6 style="text-align: center !important">Transeúnte</h6></td>                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                @endnotmobile
                <div class="card m-b-30">
                    <div class="card-body">
                        <h5>Opciones de guardado</h5>
                        <div class="row">
                            <div class="col-12">
                                <button class="w-100 btn btn-success mb-2" wire:click.prevent="submit">Guardar
                                    nuevo socio</button>
                            </div>
                        </div>
                    </div>
                </div>
                @notmobile
            </div>
            @endnotmobile
        </div>
        <style>
            fieldset.scheduler-border {
                border: 1px groove #ddd !important;
                padding: 0 1.4em 1.4em 1.4em !important;
                margin: 0 0 1.5em 0 !important;
                -webkit-box-shadow: 0px 0px 0px 0px #000;
                box-shadow: 0px 0px 0px 0px #000;
            }

            table {
                border: 1px black solid !important;
            }

            th {
                border-bottom: 1px black solid !important;
                border: 1px black solid !important;
                border-top: 1px black solid !important;
            }

            th.header {
                border-bottom: 1px black solid !important;
                border: 1px black solid !important;
                border-top: 2px black solid !important;
            }

            td.izquierda {
                border-left: 1px black solid !important;

            }

            td.derecha {
                border-right: 1px black solid !important;

            }

            td.suelo {}
        </style>
    </div>

    @section('scripts')
        {{-- <script src="https://cdn.datatables.net/responsive/2.4.0/js/dataTables.responsive.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.2/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.3.4/js/dataTables.buttons.min.js"></script> --}}
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
        {{-- <script src="https://cdn.datatables.net/buttons/2.3.4/js/buttons.html5.min.js"></script> --}}
        {{-- <script src="https://cdn.datatables.net/buttons/2.3.4/js/buttons.print.min.js"></script> --}}
        <script>
            // In your Javascript (external .js resource or <script> tag)

            $("#alertaGuardar").on("click", () => {
                Swal.fire({
                    title: '¿Estás seguro?',
                    icon: 'warning',
                    showConfirmButton: true,
                    showCancelButton: true
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.livewire.emit('submitEvento');
                    }
                });
            });

            $.datepicker.regional['es'] = {
                closeText: 'Cerrar',
                prevText: '< Ant',
                nextText: 'Sig >',
                currentText: 'Hoy',
                monthNames: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre',
                    'Octubre', 'Noviembre', 'Diciembre'
                ],
                monthNamesShort: ['Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun', 'Jul', 'Ago', 'Sep', 'Oct', 'Nov', 'Dic'],
                dayNames: ['Domingo', 'Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado'],
                dayNamesShort: ['Dom', 'Lun', 'Mar', 'Mié', 'Juv', 'Vie', 'Sáb'],
                dayNamesMin: ['Do', 'Lu', 'Ma', 'Mi', 'Ju', 'Vi', 'Sá'],
                weekHeader: 'Sm',
                dateFormat: 'yy-mm-dd',
                firstDay: 1,
                isRTL: false,
                showMonthAfterYear: false,
                yearSuffix: ''
            };
            $.datepicker.setDefaults($.datepicker.regional['es']);
            // document.addEventListener('livewire:load', function() {


            // })
            document.addEventListener("livewire:load", () => {
                Livewire.hook('message.processed', (message, component) => {
                    $('.js-example-basic-single').select2();
                });

                // $('#id_cliente').on('change', function (e) {
                // console.log('change')
                // console.log( e.target.value)
                // // var data = $('.js-example-basic-single').select2("val");
                // })
            });



            $(document).ready(function() {
                $('.js-example-basic-single').select2();
                // $('.js-example-basic-single').on('change', function (e) {
                // console.log('change')
                // console.log( e.target.value)
                // var data = $('.js-example-basic-single').select2("val");

                // @this.set('foo', data);
                //     livewire.emit('selectedCompanyItem', e.target.value)
                // });
                // $('#tableServicios').DataTable({
                //     responsive: true,
                //     dom: 'Bfrtip',
                //     buttons: [
                //         'copy', 'csv', 'excel', 'pdf', 'print'
                //     ],
                //     buttons: [{
                //         extend: 'collection',
                //         text: 'Export',
                //         buttons: [{
                //                 extend: 'pdf',
                //                 className: 'btn-export'
                //             },
                //             {
                //                 extend: 'excel',
                //                 className: 'btn-export'
                //             }
                //         ],
                //         className: 'btn btn-info text-white'
                //     }],
                //     "language": {
                //         "lengthMenu": "Mostrando _MENU_ registros por página",
                //         "zeroRecords": "Nothing found - sorry",
                //         "info": "Mostrando página _PAGE_ of _PAGES_",
                //         "infoEmpty": "No hay registros disponibles",
                //         "infoFiltered": "(filtrado de _MAX_ total registros)",
                //         "search": "Buscar:",
                //         "paginate": {
                //             "first": "Primero",
                //             "last": "Ultimo",
                //             "next": "Siguiente",
                //             "previous": "Anterior"
                //         },
                //         "zeroRecords": "No se encontraron registros coincidentes",
                //     }

            });



            // $("#fechaEmision").datepicker();


            // $("#fechaEmision").on('change', function(e) {
            //     @this.set('fechaEmision', $('#fechaEmision').val());
            // });



            function togglePasswordVisibility() {
                var passwordInput = document.getElementById("password");
                var eyeIcon = document.getElementById("eye-icon");
                if (passwordInput.type === "password") {
                    passwordInput.type = "text";
                    eyeIcon.className = "fas fa-eye-slash";
                } else {
                    passwordInput.type = "password";
                    eyeIcon.className = "fas fa-eye";
                }
            }
            //observer para aplicar el datepicker de evento
            // const observer = new MutationObserver((mutations, observer) => {
            //     console.log(mutations, observer);
            // });
            // observer.observe(document, {
            //     subtree: true,
            //     attributes: true
            // });



            document.addEventListener('DOMSubtreeModified', (e) => {
                $("#diaEvento").datepicker();

                // $("#diaEvento").on('focus', function(e) {
                //     document.getElementById("guardar-evento").style.visibility = "hidden";
                // })
                // $("#diaEvento").on('focusout', function(e) {
                //     if ($('#diaEvento').val() != "") {
                //         document.getElementById("guardar-evento").style.visibility = "visible";
                //     }

                // })
                // $("#diaFinal").on('focus', function(e) {
                //     document.getElementById("guardar-evento").style.visibility = "hidden";
                // })
                // $("#diaFinal").on('focusout', function(e) {
                //     if ($('#diaFinal').val() != "") {
                //         document.getElementById("guardar-evento").style.visibility = "visible";
                //     }

                // })

                $("#diaFinal").datepicker();

                $("#diaFinal").on('change', function(e) {
                    @this.set('diaFinal', $('#diaFinal').val());

                });

                $("#diaEvento").on('change', function(e) {
                    @this.set('diaEvento', $('#diaEvento').val());
                    @this.set('diaFinal', $('#diaEvento').val());

                });

                $('#id_cliente').on('change', function(e) {
                    console.log('change')
                    console.log(e.target.value)
                    var data = $('#id_cliente').select2("val");
                    @this.set('id_cliente', data);
                    Livewire.emit('selectCliente')

                    // livewire.emit('selectedCompanyItem', data)
                })
            })

            function OpenSecondPage() {
                var id = @this.id_cliente
                window.open(`/admin/clientes-edit/` + id, '_blank'); // default page
            };
        </script>
    @endsection
